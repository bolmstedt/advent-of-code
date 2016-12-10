<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D06;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Signals and Noise';

    protected function processPayload($input)
    {
        $letters = [];
        $raw = array_map('str_split', explode(PHP_EOL, $input));
        $length = count(reset($raw));

        for ($i = 0; $i < $length; ++$i) {
            foreach ($raw as &$array) {
                $letters[$i][] = array_shift($array);
            }
        }

        return $letters;
    }

    protected function getMessage($input, $sort)
    {
        $message = '';

        foreach ($input as $letter) {
            $counted = array_count_values($letter);
            $sort($counted);
            $message .= key($counted);
        }

        return $message;
    }

    protected function partOne($input)
    {
        return $this->getMessage($input, 'arsort');
    }

    protected function partTwo($input)
    {
        return $this->getMessage($input, 'asort');
    }
}
