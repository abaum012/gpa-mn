<?php

namespace Concrete\Package\GoogleCalendar;

use Concrete\Core\Package\Package;
use Concrete\Core\Block\BlockType\BlockType;
use Page;
use SinglePage;
use Route;
use Concrete\Core\Database\EntityManager\Provider\ProviderAggregateInterface;
use Concrete\Core\Database\EntityManager\Provider\StandardPackageProvider;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package implements ProviderAggregateInterface
{
    protected $pkgHandle = 'google_calendar';
    protected $appVersionRequired = '8.0.0.0';
    protected $pkgVersion = '1.0.0';
    protected $pkgAutoloaderMapCoreExtensions = true;

    protected $blocks = [
        'google_calendar',
        'google_calendar_events'
    ];

    protected $singlePages = [
        '/dashboard/calendar/google_calendar' => [
            'cName' => 'Google Calendar Settings',
            'cDescription' => 'Set up a google calendar by adding the API Key and Calendar ID'
        ]
    ];


    public function getPackageDescription()
    {
        return t("Google Calendar Blocks for Concrete5");
    }

    public function getEntityManagerProvider()
    {
        $provider = new StandardPackageProvider($this->app, $this, [
            'src/Concrete/Entity' => 'Concrete\Package\GoogleCalendar\Entity'
        ]);
        return $provider;
    }

    public function on_start()
    {
        $this->app->singleton('google_calendar_service', 'Concrete\Package\GoogleCalendar\GoogleCalendarService');
        Route::register('/events/get-events', 'Concrete\Package\GoogleCalendar\GoogleCalendarService::getEventsAjax');
    }

    public function install()
    {
        $pkg = parent::install();
        $this->installBlocks($pkg);
        $this->installSinglePages($pkg);
    }

    public function installBlocks($pkg)
    {
        foreach ($this->blocks as $handle)
        {
            $bt = BlockType::getByHandle($handle);
            if (!is_object($bt))
            {
                BlockType::installBlockType($handle, $pkg);
            }
            else
            {
                //make sure any db.xml changes are added to the database
                $bt->refresh();
            }
        }
    }

    public function installSinglePages($pkg)
    {
        foreach ($this->singlePages as $path => $options)
        {
            //Install single page
            $sp = Page::getByPath($path);
            if ($sp->isError() && $sp->getError() == COLLECTION_NOT_FOUND)
            {
                $sp = SinglePage::add($path, $pkg);
            }

            //Set name and description
            if (!empty($options['cName']) || !empty($options['cDescription']))
            {
                $sp->update($options);
            }
        }
    }

}