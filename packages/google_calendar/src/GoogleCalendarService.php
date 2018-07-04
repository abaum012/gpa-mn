<?php

namespace GoogleCalendar;

use Concrete\Core\Http\Request;
use GoogleCalendar\Entity\GoogleCalendar;

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

    public function getEventsByDay($calendars, $numToGet, $timeMin, $dayCount, $timeMax = null)
    {
        $events = $this->getEvents($calendars, $numToGet, $timeMin, $timeMax);

        //Sort events by date
        if ($events)
        {
            $eventsByDay = [];
            foreach($events as $event)
            {
                $date = \DateTime::createFromFormat(DATE_ISO8601, $event['start']);
                $eventsByDay[$date->format('Y-n-d')][] = $event;
            }
        }

        return array_slice($eventsByDay, 0, $dayCount);
    }

//    Used in an old version, not sure why events weren't already sorted
//    function date_compare($a, $b)
//    {
//        $t1 = $a['start'];
//        $t2 = $b['start'];
//
//        if ($t1 == $t2) return 0;
//
//        return $t1 < $t2 ? -1 : 1;
//    }

    public function sanitizeEvents($rawEvents)
    {
        $sanitizedEvents = array();

        foreach ($rawEvents as $re => $data)
        {
            if ($data->start->date) // Google sends different data for allday events
            {
                $allDay = true;
                $start = \DateTime::createFromFormat('Y-m-d', $data->start->date);
                $end = \DateTime::createFromFormat('Y-m-d', $data->end->date);
            }
            else
            {
                $allDay = false;
                $start = \DateTime::createFromFormat(DATE_RFC3339, $data->start->dateTime);
                $end = \DateTime::createFromFormat(DATE_RFC3339, $data->end->dateTime);
            }

            if ($allDay)
            {
                if($start->format('Y-n-d') == $end->format('Y-n-d')) // Same day
                {
                    $timeText = $start->format('M jS');
                }
                else
                {
                    $timeText = $start->format('M jS') . ' - ' . $end->format('M jS');
                }

            }
            else
            {
                if($start->format('Y-n-d') == $end->format('Y-n-d')) // Same day
                {
                    $timeText = $start->format('M jS, g:i a') . ' - ' . $end->format('g:i a');
                }
                else // multi day event
                {
                    $timeText = $start->format('M jS, g:i a') . ' - ' . $end->format('M jS, g:i a');
                }
            }

            $sanitizedEvents[] = array(
                'title' => $data->summary,
                'description' => $data->description,
                'allDay' => $allDay,
                'start' => $start->format(DATE_ISO8601),
                'end' => $end->format(DATE_ISO8601),
                'day' => $start->format('d'),
                'month' => $start->format('M'),
                'timeText' => $timeText,
                'location' => $data->location,
                'url' => $data->htmlLink,
                'bgColor' => $data->bgColor,
                'textColor' => $data->textColor,
                'calendarName' => $data->calendarName,
                'attachments' => $data->attachments
            );
        }

        return $sanitizedEvents;
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
        return $this->em()->getRepository('GoogleCalendar\Entity\GoogleCalendar');
    }
}