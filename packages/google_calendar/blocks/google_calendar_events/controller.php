<?php

namespace Concrete\Package\GoogleCalendar\Block\GoogleCalendarEvents;

use Concrete\Core\Block\BlockController;
use Core;
use Config;
use Page;

class Controller extends BlockController
{
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "400";
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btTable = 'btEventList';

    public function getBlockTypeName()
    {
        return 'Event List';
    }

    public function getBlockTypeDescription()
    {
        return 'Block that displays events pulled from event system in a list view.';
    }

    public function view()
    {
        $events = $this->getEvents($this->displayNum);
        
        $this->set('events', $events);
        $this->set('linkURL', $this->getLinkURL());
    }

    public function add()
    {
        $this->edit();
        $this->set('calendars', []);
    }

    public function edit()
    {
        $gcs = $this->app->make('google_calendar_service');
        $this->set('calendarList', $gcs->getCalendarList());
        $this->set('calendars', unserialize($this->calendars));
    }

    public function getLinkURL()
    {
        if (!empty($this->externalLink)) {
            return $this->externalLink;
        } else {
            if (!empty($this->internalLinkCID)) {
                $linkToC = Page::getByID($this->internalLinkCID);

                return (empty($linkToC) || $linkToC->error) ? '' : Core::make('helper/navigation')->getLinkToCollection(
                  $linkToC
                );
            } else {
                return '';
            }
        }
    }

    public function getEvents($numToGet)
    {
        $events = [];

        if ($this->calendars)
        {
            $gcs = $this->app->make('google_calendar_service');
            $events = $gcs->getEvents(unserialize($this->calendars), $numToGet, new \DateTime);
            //Sort events by date and limit to number specified
            if ($events)
            {
                usort($events, array($this, 'date_compare'));
                $events = array_slice($events, 0, $numToGet);
            }
        }

        return $events;
    }

    function date_compare($a, $b)
    {
        $t1 = $a['start'];
        $t2 = $b['start'];

        if ($t1 == $t2) return 0;

        return $t1 < $t2 ? -1 : 1;
    }

    public function save($args)
    {
        switch (isset($args['linkType']) ? intval($args['linkType']) : 0) {
            case 1:
                $args['externalLink'] = '';
                break;
            case 2:
                $args['internalLinkCID'] = 0;
                break;
            default:
                $args['externalLink'] = '';
                $args['internalLinkCID'] = 0;
                break;
        }
        unset($args['linkType']);
        $args['calendars'] = serialize($args['calendars']);
        $args['includeCalendarNames'] = isset($args['includeCalendarNames']) && $args['includeCalendarNames'] ? 1 : 0;
        parent::save($args);
    }

    public function validate($args)
    {
        $error = Core::make('helper/validation/error');

        if (!$args['calendars']) {
            $error->add(t('You must select at least 1 calendar.'));
        }

        if ($error->has()) {
            return $error;
        }
    }

}