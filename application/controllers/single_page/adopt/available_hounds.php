<?php

namespace Application\Controller\SinglePage\Adopt;

use Concrete\Core\Page\Controller\PageController;
use Concrete\Core\Page\Page;
use Concrete\Core\Support\Facade\Application;

class AvailableHounds extends PageController
{
    protected $houndService;

    public function __construct(Page $c)
    {
        $app = Application::getFacadeApplication();
        $this->houndService = $app->make('hound-service');
        parent::__construct($c);
    }

    public function view()
    {
        $this->set('hounds', $this->houndService->getHounds());
    }

}
