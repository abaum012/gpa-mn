<?php

namespace Concrete\Package\GoogleCalendar\Block\GoogleCalendarEvents;

use Concrete\Core\Block\BlockController;
use Core;
use Config;
use Page;

class Controller extends BlockController
{
    protected $btInterfaceWidth = "600";
    protected $btInterfaceHeight = "600";
    protected $btCacheBlockRecord = true;
    protected $btCacheBlockOutput = true;
    protected $btCacheBlockOutputOnPost = true;
    protected $btCacheBlockOutputForRegisteredUsers = false;
    protected $btTable = 'btEventList';

    public function getBlockTypeName()
    {
        return 'Google Event List';
    }

    public function getBlockTypeDescription()
    {
        return 'Block that displays events pulled from Google Calendar in a list view.';
    }

    public function view()
    {
        $events = $this->getEvents();

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
        if (!empty($this->externalLink))
        {
            return $this->externalLink;
        }
        else
        {
            if (!empty($this->internalLinkCID))
            {
                $linkToC = Page::getByID($this->internalLinkCID);

                return (empty($linkToC) || $linkToC->error) ? '' : Core::make('helper/navigation')->getLinkToCollection(
                    $linkToC
                );
            }
            else
            {
                return '';
            }
        }
    }

    public function getEvents()
    {
        $events = [];

        if ($this->calendars)
        {
            $gcs = $this->app->make('google_calendar_service');

            if($this->displayType == 'day')
            {
                $events = $gcs->getEventsByDay(unserialize($this->calendars), $this->eventNum, new \DateTime, $this->dayNum);
            }
            else {
                $events = $gcs->getEvents(unserialize($this->calendars), $this->eventNum, new \DateTime);
            }
        }

        return $events;
    }


    public function save($args)
    {
        switch (isset($args['linkType']) ? intval($args['linkType']) : 0)
        {
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

        switch (isset($args['displayType']) ? ($args['displayType']) : 0)
        {
            case 'event':
                $args['displayType'] = 'event';
                $args['dayNum'] = 0;
                break;
            case 'day';
                $args['displayType'] = 'day';
                break;
            default:
                $args['displayType'] = 'event';
                break;
        }


        $args['calendars'] = serialize($args['calendars']);
        $args['includeCalendarNames'] = isset($args['includeCalendarNames']) && $args['includeCalendarNames'] ? 1 : 0;
        parent::save($args);
    }

    public function validate($args)
    {
        $error = $this->app->make('helper/validation/error');

        if (!$args['calendars'])
        {
            $error->add(t('You must select at least 1 calendar.'));
        }

        if ($error->has())
        {
            return $error;
        }
    }

}