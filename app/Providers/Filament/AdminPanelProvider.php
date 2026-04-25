<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentView;
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
            ->login(\App\Filament\Pages\Auth\Login::class)
            ->profile(\App\Filament\Pages\Auth\EditProfile::class)
            ->colors([
                'primary' => Color::Violet,
            ])
            ->brandName('منصة رحلتك')
            ->brandLogo(asset('images/logo1.png'))
            ->brandLogoHeight('2.5rem')
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets',
            )
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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

    public function boot(): void
    {
        FilamentView::registerRenderHook(
            'panels::head.start',
            fn (): string => implode('', [
                '<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">',
                '<style>
                    html { direction: rtl; }
                    body, * { font-family: "Cairo", sans-serif !important; }
                    :root {
                        --primary-50: 245 243 255;
                        --primary-100: 237 233 254;
                        --primary-200: 221 214 254;
                        --primary-300: 196 181 253;
                        --primary-400: 167 139 250;
                        --primary-500: 139 92 246;
                        --primary-600: 124 58 237;
                        --primary-700: 109 40 217;
                        --primary-800: 91 33 182;
                        --primary-900: 76 29 149;
                        --primary-950: 46 16 101;
                    }
                    .fi-logo img { height: 2.5rem; width: auto; }
                    .fi-sidebar-header { background: linear-gradient(135deg, #6d28d9 0%, #9333ea 45%, #ec4899 100%) !important; }
                    .fi-sidebar-header .fi-logo { filter: brightness(0) invert(1); }
                    .fi-btn-color-primary, .fi-ac-btn-action[data-color="primary"] {
                        background: linear-gradient(135deg, #7c3aed, #ec4899) !important;
                        border: none !important;
                    }
                    .fi-badge-color-primary { background-color: rgba(124,58,237,0.12) !important; color: #7c3aed !important; }
                </style>',
            ]),
        );
    }
}
