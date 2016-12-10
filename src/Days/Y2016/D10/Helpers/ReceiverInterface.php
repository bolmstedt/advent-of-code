<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D10\Helpers;

interface ReceiverInterface
{
    public function __construct($number);
    public function getType();
    public function getNumber();
    public function receiveChip(Chip $chip);
}
