<?php

namespace Aoc\Helpers\DaySeven;

final class RightShiftGate extends SignalAbstract
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
        return $this->input->getSignal() >> $this->steps->getSignal();
    }
}
