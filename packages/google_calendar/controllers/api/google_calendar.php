<?php

namespace Concrete\Package\GoogleCalendar\Controller\Api;

use Concrete\Core\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class GoogleCalendar extends Controller
{
    protected $googleCalendarService;

    public function on_start()
    {
        parent::on_start();
        $this->googleCalendarService = $this->app->make('google_calendar_service');
    }

    public function getEvents()
    {
        $calendars = unserialize($this->request->get('calendars', null));
        $numToGet = $this->request->get('numToGet', null);
        $timeMin = $this->request->get('timeMin', null);
        $timeMax = $this->request->get('timeMax', null);

        $events = $this->googleCalendarService->getEvents($calendars, $numToGet, $timeMin, $timeMax);

        return JsonResponse::create($events);
    }

}