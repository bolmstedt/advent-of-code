<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D07;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Some Assembly Required';
    protected $testFunction = ['one' => 'testPart', 'two' => 'testPart'];
    protected $testData = [
        'one' => [
            'd' => 72,
            'e' => 507,
            'f' => 492,
            'g' => 114,
            'h' => 65412,
            'i' => 65079,
            'x' => 123,
            'y' => 456,
        ],
        'two' => [
            'd' => 72,
            'e' => 507,
            'f' => 492,
            'g' => 114,
            'h' => 65412,
            'i' => 65079,
            'x' => 123,
            'y' => 456,
        ],
    ];
    protected $wires = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->wires = [];
    }

    protected function testPart($wire)
    {
        $wire = current($wire);

        if (empty($this->wires) === true) {
            $operations = [
                '123 -> x',
                '456 -> y',
                'x AND y -> d',
                'x OR y -> e',
                'x LSHIFT 2 -> f',
                'y RSHIFT 2 -> g',
                'NOT x -> h',
                'NOT y -> i',
            ];

            $this->assignOperations($operations);
        }

        return $this->wires[$wire]->getSignal();
    }

    protected function assignOperations($operations)
    {
        foreach ($operations as $operation) {
            $this->assignOperation($operation);
        }
    }

    protected function assignOperation($operation)
    {
        preg_match('/(?<input>.*) -> (?<wire>.*)/', $operation, $matches);
        preg_match('/(?<gate>AND|OR|LSHIFT|RSHIFT|NOT)/', $matches['input'], $gates);
        preg_match_all('/(?<inputs>[a-z0-9]+)/', $matches['input'], $inputs);

        foreach ($inputs['inputs'] as $key => $input) {
            $data[$key] = is_numeric($input) === true ? new Helpers\IntegerSignal($input) : $this->getWire($input);
        }

        switch (isset($gates['gate']) === true ? $gates['gate'] : null) {
            case 'NOT':
                $signal = new Helpers\NotGate($data[0]);
                break;
            case 'AND':
                $signal = new Helpers\AndGate(
                    $data[0],
                    $data[1]
                );
                break;
            case 'OR':
                $signal = new Helpers\OrGate(
                    $data[0],
                    $data[1]
                );
                break;
            case 'LSHIFT':
                $signal = new Helpers\LeftShiftGate(
                    $data[0],
                    $data[1]
                );
                break;
            case 'RSHIFT':
                $signal = new Helpers\RightShiftGate(
                    $data[0],
                    $data[1]
                );
                break;
            default:
                $signal = $data[0];
        }

        $this->getWire($matches['wire'])->setSignal($signal);
    }

    protected function getWire($wire)
    {
        if (isset($this->wires[$wire]) === false) {
            return $this->wires[$wire] = new Helpers\Wire();
        }

        return $this->wires[$wire];
    }

    protected function partOne($input)
    {
        $this->assignOperations($input);

        return $this->wires['a']->getSignal();
    }

    protected function partTwo($input)
    {
        $partOne = $this->partOne($input);
        $this->initPart();
        $this->assignOperations($input);
        $lastOperation = $partOne.' -> b';
        $this->assignOperation($lastOperation);

        return $this->wires['a']->getSignal();
    }
}
