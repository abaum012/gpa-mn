<?php

namespace Application\Theme;

use Concrete\Core\Foundation\Service\Provider as ServiceProvider;
use Application\Theme\Bootstrap4GridFramework;
use Core;

class ThemeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $manager = Core::make('manager/grid_framework');
        $manager->extend('bootstrap4', function ($app)
        {
            return new Bootstrap4GridFramework();
        });
    }
}