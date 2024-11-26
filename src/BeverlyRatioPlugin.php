<?php

namespace Xbigdaddyx\BeverlyRatio;

use Filament\Contracts\Plugin;
use Filament\Panel;

class BeverlyRatioPlugin implements Plugin
{
    public function getId(): string
    {
        return 'beverly-ratio';
    }

    public function register(Panel $panel): void
    {
        //
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
