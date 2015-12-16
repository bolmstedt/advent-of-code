<?php

namespace Aoc\Helpers\DayFourteen;

final class Reindeer
{
    const STATE_RESTING = 0;
    const STATE_FLYING = 1;
    protected $name;
    protected $speed;
    protected $burst;
    protected $rest;
    protected $distance;
    protected $points;
    protected $secondsLeft;
    protected $state;

    public function __construct($input)
    {
        preg_match('/(?<name>.*) can fly (?<speed>\\d*) km\/s for (?<burst>\\d*) seconds, but then must rest for (?<rest>\\d*) seconds\./', $input, $matches);
        $this->name        = $matches['name'];
        $this->speed       = (int) $matches['speed'];
        $this->burst       = (int) $matches['burst'];
        $this->rest        = (int) $matches['rest'];
        $this->distance    = 0;
        $this->points      = 0;
        $this->secondsLeft = $this->burst;
        $this->state       = self::STATE_FLYING;
    }

    public function advance()
    {
        if ($this->state === self::STATE_RESTING) {
            $this->rest();
        } elseif ($this->state === self::STATE_FLYING) {
            $this->fly();
        }
    }

    public function getDistance()
    {
        return $this->distance;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function awardPoint()
    {
        $this->points++;
    }

    protected function fly()
    {
        $this->distance += $this->speed;
        $this->secondsLeft--;

        if ($this->secondsLeft === 0) {
            $this->secondsLeft = $this->rest;
            $this->state = self::STATE_RESTING;
        }
    }

    protected function rest()
    {
        $this->secondsLeft--;

        if ($this->secondsLeft === 0) {
            $this->secondsLeft = $this->burst;
            $this->state = self::STATE_FLYING;
        }
    }
}
