<?php

namespace Concrete\Package\GoogleCalendar\Block\GoogleCalendar;

use Concrete\Core\Block\BlockController;

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
        $calendarList = new CalendarList();
        $this->set('calendarList', $calendarList->getNameList());
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
        $error = Core::make('helper/validation/error');

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