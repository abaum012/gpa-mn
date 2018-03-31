<?php namespace Application\Installer;

use Concrete\Core\Foundation\Service\Provider as ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('installer', 'Application\Installer\Installer');
    }
}
