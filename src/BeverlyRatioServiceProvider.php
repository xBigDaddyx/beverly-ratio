<?php

namespace Xbigdaddyx\BeverlyRatio;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Xbigdaddyx\BeverlyRatio\Commands\BeverlyRatioCommand;
use Xbigdaddyx\BeverlyRatio\Testing\TestsBeverlyRatio;

class BeverlyRatioServiceProvider extends PackageServiceProvider
{
    public static string $name = 'beverly-ratio';

    public static string $viewNamespace = 'beverly-ratio';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('xbigdaddyx/beverly-ratio');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->bind('BeverlyRatio', \Xbigdaddyx\BeverlyRatio\BeverlyRatio::class);
    }

    public function packageBooted(): void
    {
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/beverly-ratio/{$file->getFilename()}"),
                ], 'beverly-ratio-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsBeverlyRatio());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'xbigdaddyx/beverly-ratio';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('beverly-ratio', __DIR__ . '/../resources/dist/components/beverly-ratio.js'),
            // Css::make('beverly-ratio-styles', __DIR__ . '/../resources/dist/beverly-ratio.css'),
            // Js::make('beverly-ratio-scripts', __DIR__ . '/../resources/dist/beverly-ratio.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            BeverlyRatioCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            '2024_09_10_082004_create_beverly_polybags_table',
            '2024_09_23_111502_create_beverly_ratio_tags_table',
        ];
    }
}
