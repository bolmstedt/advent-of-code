<?php

namespace Aoc\Helpers\DaySeven;

final class IntegerSignal extends SignalAbstract
{
    protected $signal;

    public function __construct($signal)
    {
        $this->signal = (int) $signal;
    }

    public function getSignal()
    {
        return $this->signal;
    }
}
