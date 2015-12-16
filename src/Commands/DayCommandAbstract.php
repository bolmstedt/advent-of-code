<?php

namespace Aoc\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Aoc\Exceptions\MissingInputException;
use Aoc\Exceptions\MissingTestException;
use Aoc\Exceptions\FailingTestException;
use Aoc\Exceptions\MissingFunctionException;

abstract class DayCommandAbstract extends Command
{
    protected $output;
    protected $input;
    protected $payload;
    protected $day;
    protected $description;
    protected $parts        = [1 => 'one', 2 => 'two'];
    protected $testFunction = [];
    protected $testData     = [];

    protected function configure()
    {
        $this->setName('day:'.str_pad($this->day, 2, '0', STR_PAD_LEFT));
        $this->setDescription($this->description);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;
        try {
            $timeStart = microtime(true);
            $this->loadPayload();
            $this->runParts();
            $timeStop = microtime(true);
            $totalTime = round(($timeStop - $timeStart)*1000);
            $this->output->writeln('Done in '.$totalTime.'ms with peak memory usage at '.round(memory_get_peak_usage()/1024/1024).'MB.');
        } catch (MissingInputException $e) {
            $this->output->writeln('<error>No input file exists yet for this day.</>');
        }
    }

    protected function runParts()
    {
        foreach ($this->parts as $key => $part) {
            $this->runPart($key, $part);
        }
    }

    protected function runPart($key, $part)
    {
        try {
            list($function, $data) = $this->getTests($key);
            $this->runTests($function, $data);
            $this->processInput($part);
        } catch (MissingTestException $e) {
            $this->output->writeln("<error>Part $part is missing tests. Not running that part.</>");
        } catch (FailingTestException $e) {
            $this->output->writeln("<error>Part $part is ".$e->getMessage().'</>');
        } catch (MissingFunctionException $e) {
            $this->output->writeln("<error>Part $part is missing.</>");
        }
    }

    protected function getTests($key)
    {
        if (empty($this->testFunction[$key]) === true || empty($this->testData[$key]) === true) {
            throw new MissingTestException;
        }
        return [$this->testFunction[$key], $this->testData[$key]];
    }

    protected function partOne($payload)
    {
        $this->missingFunction($payload);
    }

    protected function partTwo($payload)
    {
        $this->missingFunction($payload);
    }

    protected function runTests($function, array $data)
    {
        $this->initPart();
        $failed = 0;
        $total = count($data);
        foreach ($data as $input => $expected) {
            $timeStart = microtime(true);
            $calculated = $this->$function($input);
            $timeStop = microtime(true);
            $timeTotal = round(($timeStop - $timeStart)*1000);
            if ($calculated !== $expected) {
                $failed++;
                $this->output->writeln('<error>Test failed in '.$timeTotal."ms: $input -> $calculated<>$expected</>");
            } else if ($this->output->isVerbose()) {
                $this->output->writeln('<info>Test succeded in '.$timeTotal.'ms:</> '.$input.' -> '.$calculated.'=='.$expected);
            }
        }
        if ($failed > 0) {
            throw new FailingTestException("failing $failed out of $total tests.");
        }
    }

    protected function processInput($part)
    {
        $function = 'part'.ucfirst($part);
        $timeStart = microtime(true);
        $this->initPart();
        $return = $this->$function($this->payload);
        $timeStop = microtime(true);
        $timeTotal = '';
        if ($this->output->isVerbose()) {
            $timeTotal = ' in '.round(($timeStop - $timeStart)*1000).'ms';
        }
        $this->output->writeln("<info>Part $part generated the answer$timeTotal: ".$return.'</>');
    }

    protected function loadPayload()
    {
        $file = __DIR__.'/../../input/'.$this->day.'.input';
        if (file_exists($file) === false) {
            throw new MissingInputException;
            return false;
        }
        $this->payload = $this->processPayload(trim(file_get_contents($file)));
    }

    protected function processPayload($payload)
    {
        return $payload;
    }

    protected function initPart()
    {
    }

    private function missingFunction()
    {
        throw new MissingFunctionException;
    }
}
