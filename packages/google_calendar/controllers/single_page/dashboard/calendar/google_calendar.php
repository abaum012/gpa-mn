<?php

namespace Concrete\Package\GoogleCalendar\Controller\SinglePage\Dashboard\Calendar;

use Request;
use Page;
use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Core\Support\Facade\Application;

class GoogleCalendar extends DashboardPageController
{
    protected $gcs;

    public function __construct(Page $c)
    {
        parent::__construct($c);
        $app = Application::getFacadeApplication();
        $this->gcs = $app->make('google_calendar_service');
    }

    public function view()
    {
        $this->set('calendars', $this->gcs->getCalendars());
    }

    public function add()
    {
        $this->set('pageTitle', t('Add Calendar'));
    }

    public function edit($id = 0)
    {
        $cal = $this->gcs->getByID($id);
        $this->set('id', $cal->getID());
        $this->set('name', $cal->getName());
        $this->set('bgColor', $cal->getBgColor());
        $this->set('textColor', $cal->getTextColor());
        $this->set('apiKey', $cal->getApiKey());
        $this->set('googleID', $cal->getGoogleID());
        $this->set('pageTitle', t('Edit %s', h($cal->getName())));
    }

    public function saved()
    {
        $this->set('message', t('Calendar information saved successfully.'));
        $this->view();
    }

    public function deleted()
    {
        $this->set('message', t('Calendar information deleted successfully.'));
        $this->view();
    }

    //TODO Add error handling for colors
    public function submit()
    {
        if (!$this->token->validate('submit'))
        {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->post('name'))
        {
            $this->error->add(t('You must specify a name.'));
        }
        if (!$this->error->has() && $this->getRequest()->isPost())
        {
            $this->gcs->updateCalendar($this->getRequest()->post());
            $this->redirect('/dashboard/calendar/google_calendar/', 'saved');
        }
        if ($this->post('id'))
        {
            $this->edit($this->post('id'));
        }
        else
        {
            $this->add();
        }
    }

    public function delete()
    {
        if (!$this->token->validate('delete'))
        {
            $this->error->add($this->token->getErrorMessage());
        }
        if (!$this->error->has() && $this->isPost())
        {
            $cal = Calendar::getByID($this->post('calendarID'));
            if (is_object($cal))
            {
                $cal->delete();
            }
            $this->redirect('/dashboard/calendar/google_calendar', 'deleted');
        }
        $this->view();
    }
}