<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D02;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'I Was Told There Would Be No Math';
    protected $testData = [
        'one' => [
            '2x3x4' => 58,
            '1x1x10' => 43,
        ],
        'two' => [
            '2x3x4' => 34,
            '1x1x10' => 14,
        ],
    ];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function paperNeeded($dimensions)
    {
        $needed = 0;
        list($length, $width, $height) = explode('x', $dimensions);
        $xSide = $length * $width;
        $ySide = $width * $height;
        $zSide = $height * $length;
        $needed += 2 * $xSide;
        $needed += 2 * $ySide;
        $needed += 2 * $zSide;
        $needed += min($xSide, $ySide, $zSide);

        return $needed;
    }

    protected function ribbonNeeded($dimensions)
    {
        $needed = 0;
        list($length, $width, $height) = explode('x', $dimensions);
        $needed += $length * $width * $height;
        $needed += 2 * $length;
        $needed += 2 * $width;
        $needed += 2 * $height;
        $needed -= 2 * max($length, $width, $height);

        return $needed;
    }

    protected function partOne($input)
    {
        $total = 0;

        foreach ($input as $present) {
            $total += $this->paperNeeded($present);
        }

        return $total;
    }

    protected function partTwo($input)
    {
        $total = 0;

        foreach ($input as $present) {
            $total += $this->ribbonNeeded($present);
        }

        return $total;
    }
}
