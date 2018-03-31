<?php namespace Application\Installer;

class InstallerResponse
{
    protected $msg;

    protected $result;

    public function __construct($msg, $result = null)
    {
        $this->msg = $msg;
        $this->result = $result;
    }

    public function __toString()
    {
        return $this->getMessage() . '<br/>';
    }

    public function getMessage()
    {
        return $this->msg;
    }

    public function getResult()
    {
        return $this->result;
    }
}