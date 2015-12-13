<?php

namespace Aoc\Commands;

use Aoc\Helpers\DaySeven;

final class DaySevenCommand extends DayCommandAbstract
{
    protected $day          = 7;
    protected $description  = 'Some Assembly Required';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testOne',
    ];
    protected $testData     = [
        1 => [
            'd' => 72,
            'e' => 507,
            'f' => 492,
            'g' => 114,
            'h' => 65412,
            'i' => 65079,
            'x' => 123,
            'y' => 456,
        ],
        2 => [
            'd' => 72,
            'e' => 507,
            'f' => 492,
            'g' => 114,
            'h' => 65412,
            'i' => 65079,
            'x' => 123,
            'y' => 456,
        ]
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

    protected function testOne($wire)
    {
        if (empty($this->wires)) {
            $input = [
                '123 -> x',
                '456 -> y',
                'x AND y -> d',
                'x OR y -> e',
                'x LSHIFT 2 -> f',
                'y RSHIFT 2 -> g',
                'NOT x -> h',
                'NOT y -> i',
            ];

            foreach ($input as $operation) {
                $this->assignOperation($operation);
            }
        }

        return $this->wires[$wire]->getSignal();
    }

    protected function assignOperation($operation)
    {
        preg_match('/(?<input>.*) -> (?<wire>.*)/', $operation, $matches);
        preg_match('/(?<gate>AND|OR|LSHIFT|RSHIFT|NOT)/', $matches['input'], $gates);
        preg_match_all('/(?<inputs>[a-z0-9]+)/', $matches['input'], $inputs);
        foreach ($inputs['inputs'] as $key => $input) {
            $data[$key] = is_numeric($input) ? new DaySeven\IntegerSignal($input) : $this->getWire($input);
        }
        switch (isset($gates['gate']) === true ? $gates['gate'] : null) {
            case 'NOT':
                $signal = new DaySeven\NotGate($data[0]);
                break;
            case 'AND':
                $signal = new DaySeven\AndGate(
                    $data[0],
                    $data[1]
                );
                break;
            case 'OR':
                $signal = new DaySeven\OrGate(
                    $data[0],
                    $data[1]
                );
                break;
            case 'LSHIFT':
                $signal = new DaySeven\LeftShiftGate(
                    $data[0],
                    $data[1]
                );
                break;
            case 'RSHIFT':
                $signal = new DaySeven\RightShiftGate(
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
            return $this->wires[$wire] = new DaySeven\Wire();
        }
        return $this->wires[$wire];
    }

    protected function partOne($input)
    {
        foreach ($input as $operation) {
            $this->assignOperation($operation);
        }
        return $this->wires['a']->getSignal();
    }

    protected function partTwo($input)
    {
        $partOne = 3176;
        foreach ($input as $operation) {
            $this->assignOperation($operation);
        }
        $lastOperation = "$partOne -> b";
        $this->assignOperation($lastOperation);
        return $this->wires['a']->getSignal();
    }
}
