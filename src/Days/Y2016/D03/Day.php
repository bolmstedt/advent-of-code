<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D03;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Squares With Three Sides';

    protected function processPayload($input)
    {
        $triangles = explode(PHP_EOL, $input);
        array_walk($triangles, function (&$triangle) {
            $triangle = explode(' ', preg_replace('/\s+/', ' ', trim($triangle)));
        });

        return $triangles;
    }

    protected function isCorrect($triangle)
    {
        sort($triangle);

        return $triangle[0] + $triangle[1] > $triangle[2];
    }

    protected function partOne($input)
    {
        return array_reduce($input, function ($correct, $triangle) {
            if ($this->isCorrect($triangle) === true) {
                ++$correct;
            }

            return $correct;
        }, 0);
    }

    protected function fixInput($input)
    {
        $fixed = [];
        $chunks = array_chunk($input, 3);

        foreach ($chunks as $chunk) {
            $fixed[] = [$chunk[0][0], $chunk[1][0], $chunk[2][0]];
            $fixed[] = [$chunk[0][1], $chunk[1][1], $chunk[2][1]];
            $fixed[] = [$chunk[0][2], $chunk[1][2], $chunk[2][2]];
        }

        return $fixed;
    }

    protected function partTwo($input)
    {
        $input = $this->fixInput($input);

        return array_reduce($input, function ($correct, $triangle) {
            if ($this->isCorrect($triangle) === true) {
                ++$correct;
            }

            return $correct;
        }, 0);
    }
}
