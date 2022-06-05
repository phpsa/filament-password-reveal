<?php

namespace Phpsa\FilamentPasswordReveal;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentPasswordRevealProvider extends PluginServiceProvider
{
    public static string $name = 'filament-password-reveal';

    protected array $styles = [
        'filament-password-reveal-styles' => __DIR__ . '/../dist/style.css',
    ];

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)->hasViews();
    }
}
