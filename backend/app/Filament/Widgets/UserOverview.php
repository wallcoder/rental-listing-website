<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::query()->count())->description('Total Users')
            ->descriptionIcon('heroicon-m-users', IconPosition::Before)
            ->chart([1,3,4,10,20,40])->color('success'),
            Stat::make('Posts', Post::query()->count()),

        ];
    }
}
