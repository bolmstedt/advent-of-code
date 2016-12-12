<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11\Helpers;

final class ItemFactory
{
    const TYPES = [
        Chip::TYPE => Chip::class,
        Generator::TYPE => Generator::class,
    ];
    private $items = [];

    public function all()
    {
        return $this->items;
    }

    public function get($rtg, $type)
    {
        if (isset($this->items[$type.$rtg]) === false) {
            if (isset(self::TYPES[$type]) === false) {
                throw new \Exception('Unknown item type: '.$type);
            }

            $class = self::TYPES[$type];
            $this->items[$type.$rtg] = new $class($rtg);
        }

        return $this->items[$type.$rtg];
    }
}
