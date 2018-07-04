<?php

namespace Concrete\Package\GoogleCalendar\Block\GoogleCalendar;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Asset\AssetList;

class Controller extends BlockController
{
    protected $btInterfaceWidth = "300";
    protected $btInterfaceHeight = "300";
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btTable = 'btGoogleCalendar';

    public function getBlockTypeName()
    {
        return 'Google Calendar';
    }

    public function getBlockTypeDescription()
    {
        return 'Block displays Google Calendars in a full calendar view.';
    }

    public function on_start()
    {
        $al = AssetList::getInstance();
        $al->register(
            'javascript', 'moment', 'blocks/google_calendar/fullcalendar/lib/moment.min.js',
            array('version' => '3.9.0', 'minify' => false, 'combine' => true),
            'google_calendar'
        );
        $al->register(
            'javascript', 'fullcalendar', 'blocks/google_calendar/fullcalendar/fullcalendar.min.js',
            array('version' => '3.9.0', 'minify' => false, 'combine' => true),
            'google_calendar'
        );
        $al->register(
            'javascript', 'gcal', 'blocks/google_calendar/fullcalendar/gcal.min.js',
            array('version' => '3.9.0', 'minify' => false, 'combine' => true),
            'google_calendar'
        );
        $al->register(
            'css', 'fullcalendar', 'blocks/google_calendar/fullcalendar/fullcalendar.min.css',
            array('version' => '3.9.0', 'minify' => false, 'combine' => true),
            'google_calendar'
        );

        $al->registerGroup('fullcalendar', array(
            array('css', 'fullcalendar'),
            array('javascript', 'jquery'),
            array('javascript', 'moment'),
            array('javascript', 'fullcalendar'),
            array('javascript', 'gcal'),
        ));
    }

    public function registerViewAssets($outputContent = '')
    {
        $this->requireAsset('fullcalendar');
    }

    public function view()
    {
        $views = array();
        if ($this->monthView) $views[] = 'month';
        if ($this->weekView) $views[] = 'basicWeek';
        if ($this->dayView) $views[] = 'basicDay';

        if (count($views) > 1 ) $this->set('calendarViews', implode(',', $views));
        $this->set('defaultView', current($views));
        $this->set('calendars', $this->calendars);
    }

    public function add()
    {
        $this->edit();
        $this->set('calendars', array());
    }

    public function edit()
    {
        $gcs = $this->app->make('google_calendar_service');
        $this->set('calendarList', $gcs->getCalendarList());
        $this->set('calendars', unserialize($this->calendars));
    }

    public function save($args)
    {
        $args['displayWeekends'] = isset($args['displayWeekends']) && $args['displayWeekends'] ? 1 : 0;
        $args['monthView'] = isset($args['monthView']) && $args['monthView'] ? 1 : 0;
        $args['weekView'] = isset($args['weekView']) && $args['weekView'] ? 1 : 0;
        $args['dayView'] = isset($args['dayView']) && $args['dayView'] ? 1 : 0;
        $args['calendars'] = serialize($args['calendars']);
        parent::save($args);
    }

    public function validate($args)
    {
        $error = $this->app->make('helper/validation/error');

        if (!$args['monthView'] && !$args['weekView'] && !$args['dayView']) {
            $error->add(t('You must select at least 1 view.'));
        }

        if (!$args['calendars']) {
            $error->add(t('You must select at least 1 calendar.'));
        }

        if ($error->has()) {
            return $error;
        }
    }

}