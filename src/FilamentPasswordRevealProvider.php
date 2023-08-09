<?php

namespace Phpsa\FilamentPasswordReveal;

use Spatie\LaravelPackageTools\PackageServiceProvider;
use Spatie\LaravelPackageTools\Package;

class FilamentPasswordRevealProvider extends PackageServiceProvider
{
    public static string $name = 'filament-password-reveal';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name)->hasViews();
    }
}
