<?php

namespace Aoc\Helpers\DaySeven;

final class NotGate extends SignalAbstract
{
    protected $input;

    public function __construct(SignalInterface $input)
    {
        $this->input = $input;
    }

    public function getSignal()
    {
        return unpack('S', ~pack('S', $this->input->getSignal()))[1];
    }
}
