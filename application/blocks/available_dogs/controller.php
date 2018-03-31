<?php

namespace Application\Block\AvailableDogs;

use Concrete\Core\Block\BlockController;

class Controller extends BlockController
{
    protected $btInterfaceWidth = "400";
    protected $btInterfaceHeight = "400";
    protected $btTable = 'btAvailableDogs';

    public function getBlockTypeName()
    {
        return 'Available Dogs';
    }

    public function getBlockTypeDescription()
    {
        return 'Displays Dogs pulled from RescueGroup.org';
    }

    public function view()
    {
    }

    public function add()
    {
        $this->edit();
    }

    public function edit()
    {
    }

    public function save($args)
    {
        parent::save($args);
    }

    public function validate($args)
    {
        $error = Core::make('helper/validation/error');

        if ($error->has()) {
            return $error;
        }
    }

}