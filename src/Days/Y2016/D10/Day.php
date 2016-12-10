<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D10;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Balance Bots';
    protected $testFunction = ['one' => 'testPartOne', 'two' => 'testPartTwo'];

    protected function processPayload($input)
    {
        return explode(PHP_EOL, $input);
    }

    protected function initPart()
    {
        $this->receiverFactory = new Helpers\ReceiverFactory();
    }

    protected function giveChip($data)
    {
        preg_match('/^(?<value>\d+) goes to bot (?<number>\d+)/', $data, $matches);
        $bot = $this->receiverFactory->get('bot', $matches['number']);
        $bot->receiveChip(new Helpers\Chip($matches['value']));
        $bot->tryToGive();
    }

    protected function configureBot($data)
    {
        preg_match('/^(?<number>\d+) gives low to (?<lowType>\w+) (?<lowNumber>\d+) and high to (?<highType>\w+) (?<highNumber>\d+)/', $data, $matches);
        $bot = $this->receiverFactory->get('bot', $matches['number']);
        $lowReceiver = $this->receiverFactory->get($matches['lowType'], $matches['lowNumber']);
        $highReceiver = $this->receiverFactory->get($matches['highType'], $matches['highNumber']);
        $bot->setLowReceiver($lowReceiver);
        $bot->setHighReceiver($highReceiver);
        $bot->tryToGive();
    }

    protected function runInstruction($instruction)
    {
        preg_match('/^(?<function>\w+) (?<data>.*)/', $instruction, $matches);

        if ($matches['function'] === 'value') {
            return $this->giveChip($matches['data']);
        }

        $this->configureBot($matches['data']);
    }

    protected function runInstructions($instructions)
    {
        foreach ($instructions as $instruction) {
            $this->runInstruction($instruction);
        }
    }

    protected function findComparatorOf($first, $second)
    {
        foreach ($this->receiverFactory->getAll('bot') as $bot) {
            if ($bot->didCompare($first, $second) === true) {
                return $bot->getNumber();
            }
        }
    }

    protected function multiplyFirstOutputs($length)
    {
        $outputs = $this->receiverFactory->getAll('output');
        ksort($outputs);
        $multiplier = 1;

        for ($i = 0; $i < $length; ++$i) {
            $multiplier *= $outputs[$i]->getChip()->getValue();
        }

        return $multiplier;
    }

    protected function testPartOne($input)
    {
        $this->runInstructions($input);

        return $this->findComparatorOf(2, 3);
    }

    protected function partOne($input)
    {
        $this->runInstructions($input);

        return $this->findComparatorOf(61, 17);
    }

    protected function testPartTwo($input)
    {
        $this->runInstructions($input);

        return $this->multiplyFirstOutputs(3);
    }

    protected function partTwo($input)
    {
        $this->runInstructions($input);

        return $this->multiplyFirstOutputs(3);
    }
}
