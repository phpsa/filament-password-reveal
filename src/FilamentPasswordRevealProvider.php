<?php

namespace Phpsa\FilamentPasswordReveal;

use Filament\PluginServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentPasswordRevealProvider extends PluginServiceProvider
{
    public static string $name = 'filament-password-reveal';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)->hasViews();
    }
}
