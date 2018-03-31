<?php

namespace Application\Hound;

use Concrete\Core\Foundation\Service\Provider as ServiceProvider;

class HoundServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('hound-service', '\Application\Hound\HoundService');
    }
}
