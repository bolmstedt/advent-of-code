<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11\Helpers;

final class Action
{
    private $items;
    private $targetFloor;
    private $numberOfItems;

    public function __construct($items, $targetFloor)
    {
        $this->items = $items;
        $this->targetFloor = $targetFloor;
        $this->numberOfItems = count($items);
    }

    public function draw()
    {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = $item->getAcronym();
        }

        dump('Move '.implode(' ', $items).' to floor '.$this->targetFloor.'.');
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getTargetFloor()
    {
        return $this->targetFloor;
    }

    public function getNumberOfItems()
    {
        return $this->numberOfItems;
    }
}
