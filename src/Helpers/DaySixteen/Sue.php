<?php

namespace Aoc\Helpers\DaySixteen;

final class Sue
{
    protected $number;
    protected $children;
    protected $cats;
    protected $samoyeds;
    protected $pomeranians;
    protected $akitas;
    protected $vizslas;
    protected $goldfish;
    protected $trees;
    protected $cars;
    protected $perfumes;

    public function __construct($input)
    {
        preg_match('/^Sue (?<number>\\d*):/', $input, $matches);
        $this->number = (int) $matches['number'];
        preg_match_all('/(?<what>\\w+): (?<quantity>\\d+)/', $input, $matches);

        foreach ($matches['what'] as $key => $what) {
            $this->$what = $matches['quantity'][$key];
        }
    }

    public function compare(Sue $clue)
    {
        foreach ($clue->getClues() as $what => $quantity) {
            if (isset($this->$what) && $this->$what !== $quantity) {
                return false;
            }
        }
        return true;
    }

    public function compareClosely(Sue $clue)
    {
        $greaterThan = ['cats', 'trees'];
        $fewerThan = ['pomeranians', 'goldfish'];
        $otherThan = array_merge($greaterThan, $fewerThan);

        foreach ($clue->getClues() as $what => $quantity) {
            if (isset($this->$what) === true) {
                if (in_array($what, $greaterThan) === true && $this->$what <= $quantity) {
                    return false;
                } elseif (in_array($what, $fewerThan) === true && $this->$what >= $quantity) {
                    return false;
                } elseif (in_array($what, $otherThan) === false && $this->$what !== $quantity) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getClues()
    {
        return [
            'children'    => $this->children,
            'cats'        => $this->cats,
            'samoyeds'    => $this->samoyeds,
            'pomeranians' => $this->pomeranians,
            'akitas'      => $this->akitas,
            'vizslas'     => $this->vizslas,
            'goldfish'    => $this->goldfish,
            'trees'       => $this->trees,
            'cars'        => $this->cars,
            'perfumes'    => $this->perfumes,
        ];
    }
}
