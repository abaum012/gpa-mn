<?php namespace Application\Block\DogCarousel;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Support\Facade\Application;

class Controller extends BlockController
{
    protected $houndService;

    public function getBlockTypeName()
    {
        return t('Dog Carousel');
    }

    public function getBlockTypeDescription()
    {
        return t('Adds an Available Dogs Carousel to a page');
    }

    public function on_start()
    {
        $app = Application::getFacadeApplication();
        $this->houndService = $app->make('hound-service');
    }

    public function view()
    {
        $hounds = $this->houndService->getHounds();
        if ($hounds)
        {
            shuffle($hounds);
            $this->set('hounds', $hounds);
        }
    }
}
