<?php

namespace Aoc\Helpers\DaySeven;

final class Wire implements SignalInterface
{
    protected $signal;
    protected $lastSignal;

    public function __construct()
    {
    }

    public function setSignal(SignalInterface $signal)
    {
        $this->signal = $signal;
    }

    public function getSignal()
    {
        if (isset($this->lastSignal) === true) {
            return $this->lastSignal;
        }
        return $this->lastSignal = $this->signal->getSignal();
    }
}
