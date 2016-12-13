<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Radioisotope Thermoelectric Generators';
    protected $testFunction = ['one' => 'partOne', 'two' => 'partOne'];

    protected function processPayload($input)
    {
        return explode(PHP_EOL, $input);
    }

    protected function initPart()
    {
        $this->stateFactory = new Helpers\StateFactory(new Helpers\ItemFactory());
    }

    protected function doStep(array $states)
    {
        $newStates = [];
        $this->numberOfActions = 0;

        foreach ($states as $state) {
            $actions = $state->getPossibleActions();

            if (empty($actions) === true) {
                continue;
            }

            $this->numberOfActions += count($actions);

            $newStates = array_merge($newStates, $this->stateFactory->transition($state, $actions));
        }

        return $newStates;
    }

    protected function isDone($states)
    {
        foreach ($states as $state) {
            if ($state->isDone() === true) {
                return true;
            }
        }

        return false;
    }

    protected function findMinimumAmountOfSteps($input)
    {
        $steps = 0;
        $states = [$this->stateFactory->getInitial($input)];

        while ($this->isDone($states) === false) {
            if (empty($states) === true) {
                dump('All states are gone. Something went wrong.');

                return $steps;
            }

            ++$steps;
            $numberOfStates = count($states);
            $start = microtime(true);
            $states = $this->doStep($states);
            $stop = microtime(true);
            dump('Ran step '.$steps.': Computed '.$this->numberOfActions.' actions for '.$numberOfStates.' states with '.count($states).' new states discovered in '.round(($stop - $start) * 1000).' ms.');
        }

        return $steps;
    }

    protected function partOne($input)
    {
        return $this->findMinimumAmountOfSteps($input);
    }

    protected function partTwo($input)
    {
        $newThings = ' an elerium generator, an elerium-compatible microchip, a dilithium generator, a dilithium-compatible microchip ';
        $input[0] = str_replace(' and ', $newThings, $input[0]);

        return $this->findMinimumAmountOfSteps($input);
    }
}
