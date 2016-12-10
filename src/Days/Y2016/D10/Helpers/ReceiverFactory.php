<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D10\Helpers;

final class ReceiverFactory
{
    const TYPE_BOT = 'bot';
    const TYPE_OUTPUT = 'output';
    private $bots = [];
    private $outputs = [];

    public function get($type, $number)
    {
        $number = (int) $number;

        if ($type === self::TYPE_BOT) {
            return $this->getBot($number);
        }

        if ($type === self::TYPE_OUTPUT) {
            return $this->getOutput($number);
        }

        throw new \Exception('Invalid type.');
    }

    public function getAll($type)
    {
        if ($type === self::TYPE_BOT) {
            return $this->bots;
        }

        if ($type === self::TYPE_OUTPUT) {
            return $this->outputs;
        }

        throw new \Exception('Invalid type.');
    }

    protected function getBot($number)
    {
        if (isset($this->bots[$number]) === false) {
            $this->bots[$number] = new Bot($number);
        }

        return $this->bots[$number];
    }

    protected function getOutput($number)
    {
        if (isset($this->outputs[$number]) === false) {
            $this->outputs[$number] = new Output($number);
        }

        return $this->outputs[$number];
    }
}
