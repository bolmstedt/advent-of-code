<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D10\Helpers;

final class Chip
{
    private $value;

    public function __construct($value)
    {
        $this->value = (int) $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
