<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D09;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    const LOW_COMPLEXITY = 0;
    const HIGH_COMPLEXITY = 1;
    const MUTATOR_START = '(';
    const MUTATOR_PATTERN = '/^\((?<length>\d+)x(?<multiplier>\d+)\)/';

    protected $description = 'Explosives in Cyberspace';

    protected function calculateLength($string, $complexity)
    {
        $position = 0;
        $decompressed = 0;
        $length = strlen($string);

        do {
            if ($string[$position] === self::MUTATOR_START) {
                $mutator = substr($string, $position, 9);
                preg_match(self::MUTATOR_PATTERN, $mutator, $matches);
                $mutatorLength = strlen($matches[0]);
                $subString = substr($string, $position + $mutatorLength, $matches['length']);
                $position += $matches['length'] + $mutatorLength;

                if ($complexity === self::HIGH_COMPLEXITY && strpos($subString, self::MUTATOR_START) !== false) {
                    $decompressed += $matches['multiplier'] * $this->calculateLength($subString, $complexity);
                    continue;
                }

                $decompressed += $matches['length'] * $matches['multiplier'];
                continue;
            }

            ++$position;
            ++$decompressed;
        } while ($position < $length);

        return $decompressed;
    }

    protected function partOne($input)
    {
        return $this->calculateLength($input, self::LOW_COMPLEXITY);
    }

    protected function partTwo($input)
    {
        return $this->calculateLength($input, self::HIGH_COMPLEXITY);
    }
}
