<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11\Helpers;

abstract class AbstractItem implements ItemInterface
{
    private $rtg;

    public function __construct($rtg)
    {
        $this->rtg = $rtg;
    }

    public function __toString()
    {
        return $this->getAcronym();
    }

    public function getRtg()
    {
        return $this->rtg;
    }

    public function getType()
    {
        return static::TYPE;
    }

    public function getAcronym()
    {
        return $this->rtg.static::TYPE;
    }
}
