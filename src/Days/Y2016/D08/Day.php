<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D08;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Two-Factor Authentication';

    protected function processPayload($input)
    {
        return array_map(function ($operation) {
            preg_match('/(?<function>\w+) (?<data>.*)/', $operation, $matches);

            return $matches;
        }, array_filter(explode(PHP_EOL, $input)));
    }

    protected function initPart()
    {
        $this->grid = array_fill(0, 6, array_fill(0, 50, false));
    }

    protected function initTest()
    {
        $this->grid = array_fill(0, 3, array_fill(0, 7, false));
    }

    protected function drawGrid()
    {
        foreach ($this->grid as $row) {
            $string = implode(array_map(function ($field) {
                return ($field === true) ? '#' : ' ';
            }, $row));

            if (empty(trim($string)) === false) {
                dump($string);
            }
        }
    }

    protected function rect($data)
    {
        preg_match('/(?<width>\d+)x(?<height>\d+)/', $data, $matches);

        for ($i = 0; $i < $matches['height']; ++$i) {
            for ($j = 0; $j < $matches['width']; ++$j) {
                $this->grid[$i][$j] = true;
            }
        }
    }

    protected function rotateRow($index, $increment)
    {
        for ($i = 0; $i < $increment; ++$i) {
            array_unshift($this->grid[$index], array_pop($this->grid[$index]));
        }
    }

    protected function rotateColumn($index, $increment)
    {
        $original = array_column($this->grid, $index);

        for ($i = 0; $i < $increment; ++$i) {
            array_unshift($original, array_pop($original));
        }

        foreach ($original as $key => $value) {
            $this->grid[$key][$index] = $value;
        }
    }

    protected function rotate($data)
    {
        preg_match('/(?<function>\w+) \w=(?<index>\d+) by (?<increment>\d+)/', $data, $matches);
        $function = 'rotate'.ucfirst($matches['function']);
        $this->$function($matches['index'], $matches['increment']);
    }

    protected function doOperations($operations)
    {
        foreach ($operations as $operation) {
            $this->{$operation['function']}($operation['data']);
        }
    }

    protected function countgrid()
    {
        return array_reduce($this->grid, function ($carry, $item) {
            $carry += array_sum($item);

            return $carry;
        }, 0);
    }

    protected function partOne($input)
    {
        $this->doOperations($input);

        return $this->countGrid();
    }

    protected function partTwo($input)
    {
        $this->doOperations($input);
        $this->drawGrid();

        return $this->countGrid();
    }
}
