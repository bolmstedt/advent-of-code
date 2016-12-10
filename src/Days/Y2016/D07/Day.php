<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D07;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Internet Protocol Version 7';
    protected $testData = [
        'one' => [
            'abba[mnop]qrst' => '1',
            'abba[mnop]qrst[mnop]qrst[mnop]qrst' => '1',
            'abcd[bddb]xyyx' => '0',
            'abcd[mnop]qrst[mnop]qrst[bddb]xyyx[mnop]qrst' => '0',
            'aaaa[qwer]tyui' => '0',
            'ioxxoj[asdfgh]zxcvbn' => '1',
        ],
        'two' => [
            'aba[bab]xyz' => '1',
            'xyx[xyx]xyx' => '0',
            'aaa[kek]eke' => '1',
            'zazbz[bzb]cdb' => '1',
            'bzb[zazbz]cdb' => '1',
            'abc[zazbzbzb]abc' => '0',
        ],
    ];

    protected function processPayload($input)
    {
        return explode(PHP_EOL, $input);
    }

    protected function supportsTls($input)
    {
        if (preg_match('/(?:^|\])\w*?(\w)(?!\1)(\w)\2\1\w*?(?:$|\[)/', $input) === 0) {
            return false;
        }

        if (preg_match('/\[\w*(\w)(?!\1)(\w)\2\1\w*\]/', $input) === 1) {
            return false;
        }

        return true;
    }

    protected function supportsSsl($input)
    {
        $supernet = preg_replace('/\[\w*\]/', '_', $input);

        if (preg_match_all('/(\w)(?!\1)(?=(\w)\1)/', $supernet, $matches) === 0) {
            return false;
        }

        $length = count($matches[0]);

        for ($i = 0; $i < $length; ++$i) {
            $aba = $matches[2][$i].$matches[1][$i].$matches[2][$i];

            if (preg_match('/\[\w*'.$aba.'\w*\]/', $input) === 1) {
                return true;
            }
        }

        return false;
    }

    protected function getNumberOfValid($input, $function)
    {
        return array_reduce($input, function ($carry, $item) use ($function) {
            if ($this->$function($item) === true) {
                ++$carry;
            }

            return $carry;
        }, 0);
    }

    protected function partOne($input)
    {
        return $this->getNumberOfValid($input, 'supportsTls');
    }

    protected function partTwo($input)
    {
        return $this->getNumberOfValid($input, 'supportsSsl');
    }
}
