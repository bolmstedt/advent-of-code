<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11\Helpers;

final class State
{
    const DRAW_DUMP = 1;
    const DRAW_RETURN = 0;

    private $floors;
    private $items;
    private $elevator;

    public function __construct(array $floors, array $items)
    {
        krsort($floors);
        $this->floors = $floors;
        $this->items = $items;
        $this->elevator = 1;
    }

    public function getElevator()
    {
        return $this->elevator;
    }

    public function isDone()
    {
        if ($this->elevator !== 4) {
            return false;
        }

        foreach ($this->floors as $floor => $contents) {
            if ($floor !== 4 && empty($contents) === false) {
                return false;
            }
        }

        $this->draw();

        return true;
    }

    public function getHash()
    {
        $plan = [];
        $lookup = [];
        $index = 0;

        foreach ($this->floors as $floor => $contents) {
            $string = ['F'.$floor];
            $string[] = ($floor === $this->elevator) ? 'E' : '.';
            $items = [];

            foreach ($contents as $item) {
                $rtg = $item->getRtg();

                if (isset($lookup[$rtg]) === false) {
                    $lookup[$rtg] = ++$index;
                }

                $items[] = $lookup[$rtg].$item->getType();
            }

            sort($items);
            $string = implode(' ', array_merge($string, $items));
            $plan[] = $string;
        }

        return md5(implode(PHP_EOL, $plan));
    }

    public function performAction($action)
    {
        $targetFloor = $action->getTargetFloor();

        foreach ($action->getItems() as $item) {
            $this->floors[$targetFloor][$item->getAcronym()] = $item;
            unset($this->floors[$this->elevator][$item->getAcronym()]);
        }

        if (empty(end($this->floors)) === true) {
            array_pop($this->floors);
        }

        $this->elevator = $targetFloor;
    }

    public function draw()
    {
        $plan = [];

        foreach ($this->floors as $floor => $contents) {
            $string = ['F'.$floor];
            $string[] = ($floor === $this->elevator) ? 'E' : '.';

            foreach ($this->items as $acronym => $item) {
                if (in_array($item, $contents, true) ===  true) {
                    $string[] = $acronym;
                    continue;
                }

                $string[] = '..';
            }

            $string = implode(' ', $string);
            dump($string);
            $plan[] = $string;
        }

        return implode(PHP_EOL, $plan);
    }

    public function getPossibleActions()
    {
        $actions = $this->getActions();

        return array_filter($actions, [$this, 'isValidAction']);
    }

    protected function getActions()
    {
        $contents = $this->getItemsOnFloor($this->elevator);
        $possibleFloors = array_filter(array_keys($this->floors), function ($floor) {
            return abs($floor - $this->elevator) === 1;
        });

        return array_reduce($this->getPermutations($contents), function ($actions, $items) use ($possibleFloors) {
            foreach ($possibleFloors as $floor) {
                $actions[] = new Action($items, $floor);
            }

            return $actions;
        }, []);
    }

    protected function getItemsOnFloor($floor)
    {
        return $this->floors[$floor];
    }

    protected function getPermutations($contents)
    {
        $permutations = [];
        $innerContents = $contents;
        $pairFound = false;

        foreach ($contents as $key => $first) {
            $permutations[] = [$first];
            unset($innerContents[$key]);

            foreach ($innerContents as $second) {
                if ($first->getRtg() === $second->getRtg()) {
                    if ($pairFound === true) {
                        continue;
                    }

                    $pairFound = true;
                }

                $permutations[] = [$first, $second];
            }
        }

        return  $permutations;
    }

    protected function isValidAction(Action $action)
    {
        // Never move down with two items
        if ($this->elevator > $action->getTargetFloor() && $action->getNumberOfItems() === 2) {
            return false;
        }

        if ($this->canMove($action) === false) {
            return false;
        }

        return true;
    }

    protected function canMove($action)
    {
        $itemsLeft = array_filter($this->getItemsOnFloor($this->elevator), function ($item) use ($action) {
            foreach ($action->getItems() as $gone) {
                if ($gone === $item) {
                    return false;
                }
            }

            return true;
        });

        if ($this->hasUnmatchedChip($itemsLeft) === true) {
            return false;
        }

        return $this->canMoveToFloor($action);
    }

    protected function canMoveToFloor($action)
    {
        $allItems = array_merge($action->getItems(), $this->getItemsOnFloor($action->getTargetFloor()));

        if ($this->hasUnmatchedChip($allItems) === true) {
            return false;
        }

        return true;
    }

    protected function hasUnmatchedChip($items)
    {
        $chips = $this->getType($items, Chip::TYPE);
        $generators = $this->getType($items, Generator::TYPE);

        if (count($generators) === 0 || count($chips) === 0) {
            return false;
        }

        foreach ($chips as $chip) {
            foreach ($generators as $generator) {
                if ($chip->getRtg() === $generator->getRtg()) {
                    continue 2;
                }
            }

            return true;
        }

        return false;
    }

    protected function getType($items, $type)
    {
        return array_filter($items, function ($item) use ($type) {
            return $item->getType() === $type;
        });
    }
}
