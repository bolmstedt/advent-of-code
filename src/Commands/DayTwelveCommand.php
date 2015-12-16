<?php

namespace Aoc\Commands;

final class DayTwelveCommand extends DayCommandAbstract
{
    protected $day          = 12;
    protected $description  = 'JSAbacusFramework.io';
    protected $testFunction = [
        1 => 'testOne',
        2 => 'testTwo',
    ];
    protected $testData     = [
        1 => [
            '[1,2,3]'                         => 6,
            '{"a":2,"b":4}'                   => 6,
            '[1,{"c":"red","b":2},3]'         => 6,
            '{"d":"red","e":[1,2,3,4],"f":5}' => 15,
            '[[[3]]]'                         => 3,
            '{"a":{"b":4},"c":-1}'            => 3,
            '{"a":[-1,1]}'                    => 0,
            '[-1,{"a":1}]'                    => 0,
            '[]'                              => 0,
            '{}'                              => 0,
        ],
        2 => [
            '[1,2,3]'                         => 6,
            '[1,{"c":"red","b":2},3]'         => 4,
            '{"d":"red","e":[1,2,3,4],"f":5}' => 0,
            '[1,"red",5]'                     => 6,
        ]
    ];

    protected function testOne($input)
    {
        $input = $this->inputParseOne($input);
        return $this->getSum($input);
    }

    protected function testTwo($input)
    {
        $input = $this->inputParseTwo($input);
        return $this->getSum($input);
    }

    protected function getSum($array)
    {
        return $this->recursiveArraySum($array);
    }

    protected function inputParseOne($input)
    {
        return json_decode($input, true);
    }

    protected function inputParseTwo($input)
    {
        return json_decode($input);
    }

    protected function recursiveArraySum($array)
    {
        if (is_object($array)) {
            $newArray = [];
            foreach ($array as $key => $value) {
                if ($value === 'red') {
                    return 0;
                }
                $newArray[$key] = $value;
            }
            $array = $newArray;
        }
        return (int) array_reduce($array, function ($sum, $item) {
            if (is_array($item) === true || is_object($item) === true) {
                return $sum + $this->recursiveArraySum($item);
            }
            if (is_numeric($item) === true) {
                return $sum + $item;
            }
            return $sum;
        });
    }

    protected function partOne($input)
    {
        $input = $this->inputParseOne($input);
        return $this->getSum($input);
    }

    protected function partTwo($input)
    {
        $input = $this->inputParseTwo($input);
        return $this->getSum($input);
    }
}
