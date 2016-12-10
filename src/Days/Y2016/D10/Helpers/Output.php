<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D10\Helpers;

final class Output implements ReceiverInterface
{
    const TYPE = 'output';
    private $number;
    private $chip;

    public function __construct($number)
    {
        $this->number = (int) $number;
    }

    public function getType()
    {
        return self::TYPE;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getChip()
    {
        return $this->chip;
    }

    public function receiveChip(Chip $chip)
    {
        $this->chip = $chip;
    }

    public function tryToGive()
    {
    }
}
