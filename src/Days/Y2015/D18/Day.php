<?php

namespace Bolmis\AdventOfCode\Days\Y2015\D18;

use Bolmis\AdventOfCode\Commands\AbstractDayCommand;

final class Day extends AbstractDayCommand
{
    protected $description = 'Like a GIF For Your Yard';
    protected $testFunction = [
        'one' => 'testOne',
        'two' => 'testTwo',
    ];
    protected $grid = [];

    protected function processPayload($payload)
    {
        return explode(PHP_EOL, $payload);
    }

    protected function initPart()
    {
        $this->grid = [];
    }

    protected function testOne($input)
    {
        $this->generateStartingGrid($input);

        for ($i = 0; $i < 4; ++$i) {
            $this->live();
        }

        return $this->areAlive();
    }

    protected function testTwo($input)
    {
        $this->generateStartingGrid($input);
        $this->liveCorners();

        for ($i = 0; $i < 5; ++$i) {
            $this->live();
            $this->liveCorners();
        }

        return $this->areAlive();
    }

    protected function liveCorners()
    {
        $gridSize = count($this->grid)-1;
        $this->grid[0][0] = true;
        $this->grid[0][$gridSize] = true;
        $this->grid[$gridSize][0] = true;
        $this->grid[$gridSize][$gridSize] = true;
    }

    protected function areAlive()
    {
        $live = 0;

        foreach ($this->grid as $row) {
            foreach ($row as $cell) {
                $live += (int) $cell;
            }
        }

        return $live;
    }

    protected function drawGrid()
    {
        foreach ($this->grid as $row) {
            $rowBuffer = '';

            foreach ($row as $cell) {
                $rowBuffer .= $cell === true ? '#' : '.';
            }

            $this->output->writeln($rowBuffer);
        }
    }

    protected function live()
    {
        $newGrid = [];

        foreach ($this->grid as $yPos => $row) {
            foreach ($row as $xPos => $cell) {
                $newGrid[$yPos][$xPos] = $this->determineState($cell, $xPos, $yPos);
            }
        }

        $this->grid = $newGrid;
    }

    protected function determineState($cell, $xPos, $yPos)
    {
        $live = $this->countLiveNeighbours($xPos, $yPos);

        if ($cell === true && $live > 1 && $live < 4) {
            return true;
        } elseif ($cell === false && $live === 3) {
            return true;
        }

        return false;
    }

    protected function countLiveNeighbours($xPos, $yPos)
    {
        $live = 0;
        $live += (int) (empty($this->grid[$yPos-1][$xPos-1]) === false);
        $live += (int) (empty($this->grid[$yPos-1][$xPos]) === false);
        $live += (int) (empty($this->grid[$yPos-1][$xPos+1]) === false);
        $live += (int) (empty($this->grid[$yPos][$xPos-1]) === false);
        $live += (int) (empty($this->grid[$yPos][$xPos+1]) === false);
        $live += (int) (empty($this->grid[$yPos+1][$xPos-1]) === false);
        $live += (int) (empty($this->grid[$yPos+1][$xPos]) === false);
        $live += (int) (empty($this->grid[$yPos+1][$xPos+1]) === false);

        return $live;
    }

    protected function generateStartingGrid($input)
    {
        foreach ($input as $row) {
            $length = strlen($row);
            $gridRow = [];

            for ($i = 0; $i < $length; ++$i) {
                $gridRow[] = $row[$i] === '#';
            }

            $this->grid[] = $gridRow;
        }
    }

    protected function partOne($input)
    {
        $this->generateStartingGrid($input);

        for ($i = 0; $i < 100; ++$i) {
            $this->live();
        }

        return $this->areAlive();
    }

    protected function partTwo($input)
    {
        $this->generateStartingGrid($input);
        $this->liveCorners();

        for ($i = 0; $i < 100; ++$i) {
            $this->live();
            $this->liveCorners();
        }

        return $this->areAlive();
    }
}
