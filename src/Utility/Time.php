<?php

namespace App\Utility;

use DateTime;
use Exception;

class Time
{
    private $time;

    public function getHours()
    {
        return intval($this->time / 100);
    }

    public function getMinutes()
    {
        return $this->time % 100;
    }

    public function getTimeValue()
    {
        return $this->time;
    }

    public function getTimeString()
    {
        return "{$this->getHours()}:{$this->getMinutes()}";
    }

    public function __construct($timeString = "now")
    {
        if ($timeString == "now") {
            $this->time = intval((new DateTime())->format("Hi"));
        } elseif (self::validateTimeString($timeString)) {
            [$hours, $minutes] = explode(":", $timeString);

            $this->time = intval($hours) * 100 + intval($minutes);
        } else {
            throw new Exception("Incorrect time format");
        }
    }

    public function isEarlierThan(Time $time)
    {
        return $this->time < ($time->getTimeValue());
    }

    public function isLaterThan(Time $time)
    {
        return $this->time > ($time->getTimeValue());
    }

    public static function createFromValue($value)
    {
        $timeValueString = substr("0000{$value}", 4, 4);
        $timeString = substr($timeValueString, 0, 2) . ":" . substr($timeValueString, 2, 2);

        if (self::validateTimeString($timeString)) {
            return new Time($timeString);
        }

        throw new Exception("Incorrect time value");
    }

    protected static function validateTimeString($timeString)
    {
        return preg_match("/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/", $timeString);
    }
}
