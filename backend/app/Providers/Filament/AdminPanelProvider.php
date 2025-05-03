<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->font('Outfit')
            ->colors([
                'primary' => '#F50761',
            ])
            ->viteTheme('')
            ->globalSearchKeyBindings(['comand+k', 'ctrl+k'])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('15rem')
            ->brandName('inlist')
            ->collapsedSidebarWidth('4rem') 
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->navigationItems([
                NavigationItem::make('Main Website')
                ->url('http://localhost:5173', shouldOpenInNewTab: true)
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->group('External')
                ->sort(1),
                NavigationItem::make('Map')
                ->url('https://www.google.co.in/maps', shouldOpenInNewTab: true)
                ->icon('heroicon-o-map')
                ->group('External')
                ->sort(2)
            ])
            ->userMenuItems([
                MenuItem::make()->label('Settings')
                ->url('')
                ->icon('heroicon-o-cog-6-tooth')
            ])
            ->breadcrumbs(true)
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
