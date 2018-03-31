<?php

namespace Concrete\Package\GoogleCalendar\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="GoogleCalendars")
 */
class GoogleCalendar
{
    /**
     * @ORM\Id @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $bgColor;

    /**
     * @ORM\Column(type="string")
     */
    protected $textColor;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $apiKey;

    /**
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    protected $googleID;

    /*
    |--------------------------------------------------------------------------
    | GETTERS
    |--------------------------------------------------------------------------
    */

    public function getID()
    {
        return $this->id;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getGoogleID()
    {
        return $this->googleID;
    }

    public function getBgColor()
    {
        return $this->bgColor;
    }

    public function getTextColor()
    {
        return $this->textColor;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function getByID($calendarID)
    {
        $em = Database::get()->getEntityManager();
        return $em->getRepository('\Concrete\Package\GoogleCalendar\Entity\Calendar')
            ->find($calendarID);
    }

    public static function getCalendar($name)
    {
        $em = Database::get()->getEntityManager();
        return $em->getRepository('\Concrete\Package\GoogleCalendar\Entity\Calendar')
            ->find($name);
    }

    /*
    |--------------------------------------------------------------------------
    | SETTERS
    |--------------------------------------------------------------------------
    */

    public function setID($id)
    {
        $this->id = $id;
    }

    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function setGoogleID($googleID)
    {
        $this->googleID = $googleID;
    }

    public function setBgColor($bgColor)
    {
        $this->bgColor = $bgColor;
    }

    public function setTextColor($textColor)
    {
        $this->textColor = $textColor;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}
