<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D10\Helpers;

final class Bot implements ReceiverInterface
{
    const TYPE = 'bot';
    private $number;
    private $lowReceiver;
    private $highReceiver;
    private $chips = [];
    private $comparisons = [];

    public function __construct($number)
    {
        $this->number = (int) $number;
    }

    public function getType()
    {
        return self::TYPE;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function receiveChip(Chip $chip)
    {
        array_push($this->chips, $chip);
    }

    public function setLowReceiver(ReceiverInterface $receiver)
    {
        $this->lowReceiver = $receiver;
    }

    public function setHighReceiver(ReceiverInterface $receiver)
    {
        $this->highReceiver = $receiver;
    }

    public function didCompare($chipOne, $chipTwo)
    {
        return isset($this->comparisons[$chipOne][$chipTwo]);
    }

    public function tryToGive()
    {
        if ($this->hasReceivers() === true && count($this->chips) === 2) {
            $this->giveChips();
        }
    }

    protected function hasReceivers()
    {
        return isset($this->lowReceiver) && isset($this->highReceiver);
    }

    protected function giveChips()
    {
        usort($this->chips, function ($chipOne, $chipTwo) {
            return ($chipOne->getValue() < $chipTwo->getValue()) ? -1 : 1;
        });

        $lowChip = array_shift($this->chips);
        $highChip = array_shift($this->chips);
        $this->comparisons[$lowChip->getValue()][$highChip->getValue()] = true;
        $this->comparisons[$highChip->getValue()][$lowChip->getValue()] = true;
        $this->lowReceiver->receiveChip($lowChip);
        $this->highReceiver->receiveChip($highChip);
        $this->lowReceiver->tryToGive();
        $this->highReceiver->tryToGive();
    }
}
