<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D05;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'How About a Nice Game of Chess?';
    protected $testData = [
        'one' => [
            'abc' => '18f47a30',
        ],
        'two' => [
            'abc' => '05ace8e3',
        ],
    ];

    protected function findZeroHashIndex($key, $length, $index = 0)
    {
        $match = str_repeat('0', $length);

        do {
            ++$index;
        } while (strpos(md5($key.$index), $match) !== 0);

        return $index;
    }

    protected function getSequencedPasswordForKey($key)
    {
        $index = 0;
        $password = '';

        for ($i = 0; $i < 8; ++$i) {
            $index = $this->findZeroHashIndex($key, 5, $index);
            $password .= substr(md5($key.$index), 5, 1);
        }

        return $password;
    }

    protected function partOne($input)
    {
        return $this->getSequencedPasswordForKey($input);
    }

    protected function getRandomPasswordForKey($key)
    {
        $index = 0;
        $password = '________';

        for ($i = 0; $i < 8; ++$i) {
            $index = $this->findZeroHashIndex($key, 5, $index);
            $hash = md5($key.$index);
            $position = $hash[5];

            if (is_numeric($position) === false || $position > '7' || $password[$position] !== '_') {
                --$i;
                continue;
            }

            $password[$position] = $hash[6];
        }

        return $password;
    }

    protected function partTwo($input)
    {
        return $this->getRandomPasswordForKey($input);
    }
}
