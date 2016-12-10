<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D07\Helpers;

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
