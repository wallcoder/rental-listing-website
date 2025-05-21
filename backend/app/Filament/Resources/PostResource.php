<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Markdown;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Group::make()->schema([
                Section::make('Property Information')->schema([
                    Select::make('user_id')
                        ->relationship('user', 'name')->label('Posted by')
                        ->preload()
                        ->required()
                        ->columnSpan('half'),
                    Select::make('category')
                        ->options(['house' => 'House', 'shop' => 'Shop'])
                        ->preload()
                        ->required()
                        ->live()
                        ->columnSpan('half')
                        ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                            if ($operation !== 'create') {
                                return;
                            }
                            $random = \Illuminate\Support\Str::random(10);
                            $slug = \Illuminate\Support\Str::slug($state . '-' . 'rental' . '-' . $random);
                            $set('slug', $slug);
                        }),
                    Select::make('type')
                        ->options(['concrete' => 'Concrete', 'assam-type' => 'Assam-type'])
                        ->default('concrete')
                        ->preload()
                        ->required()
                        ->columnSpan('half'),
                    TextInput::make('owner_name')->required()->maxLength(255)->label("Owner's name")->placeholder('Enter name of the owner'),
                    TextInput::make('phone')->required()->maxLength(255)->numeric()->placeholder('Enter phone number'),
                    TextInput::make('email')->required()->maxLength(255)->type('email')->placeholder('Enter email'),
                    TextInput::make('slug')->required()->readOnly()->dehydrated()->reactive()->placeholder('Select category to generate slug')
                        ->unique(ignoreRecord: true),
                    Select::make('status')->options(['active' => 'Active', 'expired' => 'Expired', 'deleted' => 'Deleted', 'inactive' => 'Inactive'])
                        ->default('active')->required()->preload(),
                    FileUpload::make('thumbnail')
                        ->image()
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageCropAspectRatio('16:9')
                        ->acceptedFileTypes(['image/jpeg'])
                        ->maxSize(1024)
                        ->visibility('public')
                        ->required()
                        ->columnSpanFull()
                ])->columns(2),

                Section::make('House Details')->relationship('house')->schema([
                    TextInput::make('price')->numeric()->required()->placeholder('Enter Price'),
                    TextInput::make('area')->numeric()->required()->label('Area(sq.m)')->placeholder('Enter Area in sq.m'),
                    TextInput::make('description')->required()->columnSpanFull()->placeholder('Enter Description'),
                    Select::make('balcony')->options(['yes' => 'Yes', 'no' => 'No'])->required()->preload(),
                    Select::make('parking')->options(['yes' => 'Yes', 'no' => 'No'])->required()->preload(),
                    Select::make('furnished')->options(['yes' => 'Yes', 'no' => 'No'])->required()->preload(),
                    TextInput::make('bathroom')->numeric()->required()->placeholder('Enter number of bathrooms'),
                    TextInput::make('bedroom')->numeric()->required()->placeholder('Enter number of bedrooms'),
                ])->columns(2)->visible(fn (Forms\Get $get) => $get('category') === 'house'),

                Section::make('Shop Details')->relationship('shop')->schema([
                    TextInput::make('price')->numeric()->required()->placeholder('Enter Price'),
                    TextInput::make('area')->numeric()->required()->label('Area(sq.m)')->placeholder('Enter Area in sq.m'),
                    TextInput::make('description')->required()->columnSpanFull()->placeholder('Enter Description'),
                    Select::make('electricity')->options(['yes' => 'Yes', 'no' => 'No'])->required()->preload(),
                    Select::make('water_supply')->options(['yes' => 'Yes', 'no' => 'No'])->required()->preload(),
                    Select::make('attached_bathroom')->options(['yes' => 'Yes', 'no' => 'No'])->required()->preload(),
                    Select::make('floor')->options([
                        'Ground Floor' => 'Ground Floor',
                        'First Floor' => 'First Floor',
                        'Second Floor' => 'Second Floor',
                        'Third Floor' => 'Third Floor',
                        'Fourth Floor' => 'Fourth Floor',
                        'Fifth Floor' => 'Fifth Floor',
                        'Sixth Floor' => 'Sixth Floor',
                        'Seventh Floor' => 'Seventh Floor',
                        'Eighth Floor' => 'Eighth Floor',
                        'Ninth Floor' => 'Ninth Floor',
                    ])->required()->preload(),
                ])->columns(2)->visible(fn (Forms\Get $get) => $get('category') === 'shop'),
            ]),

            Group::make()->schema([
                Section::make('Location')->relationship('location')->schema([
                    TextInput::make('latitude')->numeric()->required()->placeholder('Enter Latitude'),
                    TextInput::make('longitude')->numeric()->required()->placeholder('Enter Longitude'),
                    TextInput::make('street')->placeholder('Enter Street Name'),
                    TextInput::make('locality')->placeholder('Enter Locality'),
                    TextInput::make('city')->placeholder('Enter City')->required(),
                    TextInput::make('state')->placeholder('Enter State')->required(),
                    TextInput::make('pincode')->placeholder('Enter Pincode'),
                    TextInput::make('country')->placeholder('Enter Country')->default('India')->readOnly()->required(),
                ])->columns(2),

                Repeater::make('image')
     ->relationship()
    ->schema([
        FileUpload::make('path')
            ->label('Image')
            ->required()
            ->directory('uploads')
            ->acceptedFileTypes(['image/jpeg', 'image/png'])
            ->image()
            ->maxSize(10048),
    ])
    ->minItems(5)
    ->maxItems(10)
    ->reorderable()
    ->collapsible(),
            ]),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
