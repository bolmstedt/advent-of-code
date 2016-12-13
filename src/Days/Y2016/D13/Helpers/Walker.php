<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D13\Helpers;

final class Walker
{
    private $xPos;
    private $yPos;
    private $plan;

    public function __construct(Plan $plan, $startX, $startY)
    {
        $this->plan = $plan;
        $this->moveTo($startX, $startY);
    }

    public function walk()
    {
        $newWalkers = [];

        foreach ($this->getDirections() as $direction) {
            if ($this->plan->isFree($direction[0], $direction[1]) === true) {
                $newWalker = clone $this;
                $newWalker->moveTo($direction[0], $direction[1]);
                $newWalkers[] = $newWalker;
            }
        }

        return $newWalkers;
    }

    public function moveTo($xPos, $yPos)
    {
        $this->xPos = $xPos;
        $this->yPos = $yPos;
        $this->plan->visit($xPos, $yPos);
    }

    public function getX()
    {
        return $this->xPos;
    }

    public function getY()
    {
        return $this->yPos;
    }

    protected function getDirections()
    {
        return [
            [$this->xPos+1, $this->yPos],
            [$this->xPos-1, $this->yPos],
            [$this->xPos, $this->yPos+1],
            [$this->xPos, $this->yPos-1],
        ];
    }
}
