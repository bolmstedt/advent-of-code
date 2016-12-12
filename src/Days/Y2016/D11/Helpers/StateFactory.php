<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11\Helpers;

final class StateFactory
{
    private $itemFactory;
    private $states = [];

    public function __construct(ItemFactory $itemFactory)
    {
        $this->itemFactory = $itemFactory;
    }

    public function transition(State $state, array $actions)
    {
        $newStates = [];

        foreach ($actions as $action) {
            $newState = clone $state;
            $newState->performAction($action);
            $hash = $newState->getHash();

            if (isset($this->states[$hash]) === false) {
                $this->states[$hash] = true;
                $newStates[] = $newState;
            }
        }

        return $newStates;
    }

    public function getInitial($input)
    {
        $initialFloors = [];

        foreach ($input as $floor => $contents) {
            preg_match_all('/ an? (?<item>[\w-]+ [\w-]+)/', $contents, $matches);
            $initialFloors[$floor + 1] = [];

            foreach ($matches['item'] as $itemName) {
                preg_match('/(?<rtg>\w)[\w-]+ (?<type>\w)/', ucwords($itemName), $data);
                $item = $this->itemFactory->get($data['rtg'], $data['type']);
                $initialFloors[$floor + 1][$item->getAcronym()] = $item;
            }
        }

        $initialState = new State($initialFloors, $this->itemFactory->all());
        $this->states[$initialState->getHash()] = $initialState;
        $initialState->draw();

        return $initialState;
    }
}
