<?php

namespace Bolmis\AdventOfCode\Days\Y2016\D11\Helpers;

final class ActionFactory
{
    private $actions = [];

    public function get($items, $floor)
    {
        $hash = md5(implode($items).$floor);

        if (isset($this->actions[$hash]) === false) {
            $this->actions[$hash] = new Action($items, $floor);
        }

        return $this->actions[$hash];
    }
}
