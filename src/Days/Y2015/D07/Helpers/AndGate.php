<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D07\Helpers;

final class AndGate extends SignalAbstract
{
    protected $firstInput;
    protected $secondInput;

    public function __construct(SignalInterface $firstInput, SignalInterface $secondInput)
    {
        $this->firstInput = $firstInput;
        $this->secondInput = $secondInput;
    }

    public function getSignal()
    {
        return $this->firstInput->getSignal() & $this->secondInput->getSignal();
    }
}
