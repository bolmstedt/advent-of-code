<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D02;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Bathroom Security';

    protected function initPart()
    {
        $this->yPos = 0;
        $this->xPos = 0;
        $this->code = '';
    }

    protected function setKeypadOne()
    {
        $this->keypad = [
            -1 => [
                -1 => 1,
                0 => 2,
                1 => 3,
            ],
            0 => [
                -1 => 4,
                0 => 5,
                1 => 6,
            ],
            1 => [
                -1 => 7,
                0 => 8,
                1 => 9,
            ],
        ];
    }

    protected function setKeypadTwo()
    {
        $this->keypad = [
            -2 => [
                2 => 1,
            ],
            -1 => [
                1 => 2,
                2 => 3,
                3 => 4,
            ],
            0 => [
                0 => 5,
                1 => 6,
                2 => 7,
                3 => 8,
                4 => 9,
            ],
            1 => [
                1 => 'A',
                2 => 'B',
                3 => 'C',
            ],
            2 => [
                2 => 'D',
            ],
        ];
    }

    protected function processPayload($input)
    {
        return array_map('str_split', explode(PHP_EOL, $input));
    }

    protected function pressDigit($digit)
    {
        $this->code .= $digit;
    }

    protected function getCurrentDigit()
    {
        return $this->keypad[$this->yPos][$this->xPos];
    }

    protected function moveInDirection($direction)
    {
        switch ($direction) {
            case 'U':
                if (isset($this->keypad[$this->yPos-1][$this->xPos]) === true) {
                    $this->yPos = $this->yPos-1;
                }

                return;
            case 'D':
                if (isset($this->keypad[$this->yPos+1][$this->xPos]) === true) {
                    $this->yPos = $this->yPos+1;
                }

                return;
            case 'L':
                if (isset($this->keypad[$this->yPos][$this->xPos-1]) === true) {
                    $this->xPos = $this->xPos-1;
                }

                return;
            case 'R':
                if (isset($this->keypad[$this->yPos][$this->xPos+1]) === true) {
                    $this->xPos = $this->xPos+1;
                }
        }
    }

    protected function moveFinger($directions)
    {
        foreach ($directions as $direction) {
            $this->moveInDirection($direction);
        }
    }

    protected function typeCode($instructions)
    {
        foreach ($instructions as $instruction) {
            $this->moveFinger($instruction);
            $this->pressDigit($this->getCurrentDigit());
        }
    }

    protected function partOne($input)
    {
        $this->setKeypadOne();
        $this->typeCode($input);

        return $this->code;
    }

    protected function partTwo($input)
    {
        $this->setKeypadTwo();
        $this->typeCode($input);

        return $this->code;
    }
}
