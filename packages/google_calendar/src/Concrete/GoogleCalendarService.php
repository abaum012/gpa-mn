<?php

namespace Concrete\Package\GoogleCalendar;

use Concrete\Core\Http\Request;
use Concrete\Package\GoogleCalendar\Entity\GoogleCalendar;

class GoogleCalendarService
{
    public function getCalendars()
    {
        return $this->getGoogleCalendarRepository()->findAll();
    }

    public function getCalendarList()
    {
        $calendars = $this->getCalendars();
        $cl = [];
        foreach ($calendars as $cal)
        {
            $cl[$cal->getID()] = $cal->getName();
        }

        return $cl;
    }

    public function getByID($id)
    {
        $gcr = $this->getGoogleCalendarRepository();
        return $gcr->find($id);
    }

    public function updateCalendar($data)
    {
        if ($data['id'])
        {
            $cal = $this->getByID($data['id']);
        }
        else
        {
            $cal = new GoogleCalendar();
        }
        $cal->setName($data['name']);
        $cal->setBgColor($data['bgColor']);
        $cal->setTextColor($data['textColor']);
        $cal->setApiKey($data['apiKey']);
        $cal->setGoogleID($data['googleID']);
        $this->em()->persist($cal);
        $this->em()->flush();
    }

    public function getEvents($calendars, $numToGet, $timeMin, $timeMax = null)
    {
        $events = array();
        foreach ($calendars as $index => $id)
        {
            $cal = $this->getByID($id);

            if (is_object($timeMin))
            {
                $timeMinRFC = $timeMin->format(DATE_RFC3339);
            }
            else
            {
                $timeMinRFC = \DateTime::createFromFormat('Y-m-d', $timeMin)->format(DATE_RFC3339);
            }

            if ($timeMax)
            {
                $timeMaxRFC = \DateTime::createFromFormat('Y-m-d', $timeMax)->format(DATE_RFC3339);
            }

            if ($cal->getApiKey() && $cal->getGoogleID())
            {
                $baseURL = 'https://www.googleapis.com/calendar/v3/calendars';
                $url = $baseURL . '/' . $cal->getGoogleID() . '/events?';
                $opts = array(
                    'key' => $cal->getApiKey(),
                    'maxResults' => $numToGet,
                    'singleEvents' => 'true',
                    'orderBy' => 'startTime',
                    'timeMin' => $timeMinRFC,
                    'timeMax' => $timeMaxRFC
                );

                $queryUrl = $url . http_build_query($opts);
                $json = file_get_contents($queryUrl);
                $decoded = json_decode($json);

                //add calendar colors to each event
                foreach ($decoded->items as $e)
                {
                    $e->bgColor = $cal->getBgColor();
                    $e->textColor = $cal->getTextColor();
                    $e->calendarName = $cal->getName();
                }

                $events = array_merge($events, $decoded->items);
            }
        }

        $events = $this->sanitizeEvents($events);
        return $events;
    }

    public function getEventsByDay($daysNum, $calendars, $numToGet, $timeMin)
    {
        $events = $this->getEvents($calendars, $numToGet, $timeMin);
        dd($events);
    }

    public function sanitizeEvents($rawEvents)
    {
        $sanitizedEvents = array();

        foreach ($rawEvents as $re => $data)
        {
            if ($data->start->date)
            {
                $startTime = \DateTime::createFromFormat('Y-m-d', $data->start->date);
                $endTime = \DateTime::createFromFormat('Y-m-d', $data->end->date);
                $allDay = true;
            }
            else
            {
                $startTime = \DateTime::createFromFormat(DATE_RFC3339, $data->start->dateTime);
                $endTime = \DateTime::createFromFormat(DATE_RFC3339, $data->end->dateTime);
                $allDay = false;
            }

            $sanitizedEvents[] = array(
                'title' => $data->summary,
                'description' => $data->description,
                'allDay' => $allDay,
                'start' => $startTime->format(DATE_ISO8601),
                'end' => $endTime->format(DATE_ISO8601),
                'location' => $data->location,
                'url' => $data->htmlLink,
                'bgColor' => $data->bgColor,
                'textColor' => $data->textColor,
                'calendarName' => $data->calendarName
            );
        }

        return $sanitizedEvents;
    }

    public function getEventsAjax()
    {
        //NOTE: this is set up to retrieve events from a Google Calendar since the package event system isn't written yet
        $request = Request::getInstance();

        $calendars = unserialize($request->get('calendars'));
        $numToGet = $request->get('numToGet');
        $timeMin = $request->get('timeMin');
        $timeMax = $request->get('timeMax');

        $events = $this->getEvents($calendars, $numToGet, $timeMin, $timeMax);
        echo json_encode($events);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected function em()
    {
        return \ORM::entityManager();
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getGoogleCalendarRepository()
    {
        return $this->em()->getRepository('Concrete\Package\GoogleCalendar\Entity\GoogleCalendar');
    }
}