<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D07\Helpers;

final class LeftShiftGate extends SignalAbstract
{
    protected $input;
    protected $steps;

    public function __construct(SignalInterface $input, SignalInterface $steps)
    {
        $this->input = $input;
        $this->steps = $steps;
    }

    public function getSignal()
    {
        return $this->input->getSignal() << $this->steps->getSignal();
    }
}
