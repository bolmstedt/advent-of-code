<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D12;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Leonardo\'s Monorail';

    protected function processPayload($input)
    {
        return array_map(function ($value) {
            $parts = explode(' ', $value);

            if (count($parts) > 2) {
                $parts[1] = array_slice($parts, 1);
            }

            return $parts;
        }, explode(PHP_EOL, $input));
    }

    protected function initPart()
    {
        $this->register = [
            'a' => 0,
            'b' => 0,
            'c' => 0,
            'd' => 0,
        ];
    }

    protected function readRegister($value)
    {
        return (is_numeric($value) === true) ? $value : $this->register[$value];
    }

    protected function cpy($data)
    {
        $this->register[$data[1]] = $this->readRegister($data[0]);

        return 1;
    }

    protected function inc($data)
    {
        ++$this->register[$data];

        return 1;
    }

    protected function dec($data)
    {
        --$this->register[$data];

        return 1;
    }

    protected function jnz($data)
    {
        return ($this->readRegister($data[0]) === 0) ? 1 : $this->readRegister($data[1]);
    }

    protected function assembunny($input)
    {
        $length = count($input);

        for ($i = 0; $i < $length; $i += $step) {
            $step = $this->{$input[$i][0]}($input[$i][1]);
        }
    }

    protected function partOne($input)
    {
        $this->assembunny($input);

        return $this->register['a'];
    }

    protected function partTwo($input)
    {
        $this->register['c'] = 1;
        $this->assembunny($input);

        return $this->register['a'];
    }
}
