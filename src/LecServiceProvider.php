<?php

declare(strict_types=1);

namespace MichaelRubel\EnhancedContainer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LecServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     */
    public function configurePackage(Package $package): void
    {
        $package->name('laravel-enhanced-container');
    }
}
