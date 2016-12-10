<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D07\Helpers;

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
