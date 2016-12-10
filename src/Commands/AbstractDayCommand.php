<?php

namespace Bolmis\AdventOfCode\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Bolmis\AdventOfCode\Exceptions;

abstract class AbstractDayCommand extends Command
{
    protected $output;
    protected $input;
    protected $payload;
    protected $description;
    protected $parts = ['one', 'two'];
    protected $testFunction = ['one' => 'partOne', 'two' => 'partTwo'];
    protected $testData = ['one' => [], 'two' => []];

    protected function configure()
    {
        $parts = explode('\\', mb_strtolower(static::class));
        $year = substr($parts[3], 1);
        $day = substr($parts[4], 1);
        $this->setName('y'.$year.':'.$day);
        $this->setDescription($this->description.' [http://adventofcode.com/'.$year.'/day/'.intval($day).']');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '512M');
        $this->output = $output;
        $this->input = $input;

        try {
            $this->loadPayload();
            $timeStart = microtime(true);
            $this->runParts();
            $timeStop = microtime(true);
            $totalTime = round(($timeStop - $timeStart)*1000);
            $this->output->writeln('<info>Done in '.$totalTime.'ms with peak memory usage at '.round(memory_get_peak_usage()/1024/1024).'MB.</>');
        } catch (Exceptions\MissingInputException $e) {
            $this->output->writeln('<comment>No input file exists yet for this day.</>');
        }
    }

    protected function processPayload($payload)
    {
        return $payload;
    }

    protected function initPart()
    {
    }

    protected function initTest()
    {
        $this->initPart();
    }

    protected function partOne($payload)
    {
        $this->missingFunction($payload);
    }

    protected function partTwo($payload)
    {
        $this->missingFunction($payload);
    }

    private function runParts()
    {
        foreach ($this->parts as $part) {
            $this->runPart($part);
        }
    }

    private function runPart($part)
    {
        try {
            list($function, $data) = $this->getTests($part);
            $this->runTests($function, $data);
            $this->processInput($part);
        } catch (Exceptions\MissingTestException $e) {
            $this->output->writeln('<comment>Part '.$part.' is missing tests. Not running that part.</>');
        } catch (Exceptions\FailingTestException $e) {
            $this->output->writeln('<error>Part '.$part.' is '.$e->getMessage().'</>');
        } catch (Exceptions\MissingFunctionException $e) {
            $this->output->writeln('<comment>Part '.$part.' is missing.</>');
        }
    }

    private function getTests($part)
    {
        if (empty($this->testFunction[$part]) === true || empty($this->testData[$part]) === true) {
            throw new Exceptions\MissingTestException();
        }

        return [$this->testFunction[$part], $this->testData[$part]];
    }

    private function runTests($function, array $data)
    {
        $failed = 0;
        $total = count($data);

        foreach ($data as $input => $expected) {
            $timeStart = microtime(true);
            $this->initTest();
            $calculated = (string) $this->$function($this->processPayload($input));
            $timeStop = microtime(true);
            $timeTotal = round(($timeStop - $timeStart)*1000);

            if ($calculated !== (string) $expected) {
                ++$failed;
                $this->output->writeln('<error>Test failed in '.$timeTotal.'ms: '.$input.' -> '.$calculated.'<>'.$expected.'</>');
            } elseif ($this->output->isVerbose() === true) {
                $this->output->writeln('<info>Test succeded in '.$timeTotal.'ms:</> '.$input.' -> '.$calculated.'=='.$expected);
            }
        }

        if ($failed > 0) {
            throw new Exceptions\FailingTestException('failing '.$failed.' out of '.$total.' tests.');
        }
    }

    private function processInput($part)
    {
        $function = 'part'.ucfirst($part);
        $timeStart = microtime(true);
        $this->initPart();
        $return = $this->$function($this->payload);
        $timeStop = microtime(true);
        $timeTotal = '';

        if ($this->output->isVerbose() === true) {
            $timeTotal = ' in '.round(($timeStop - $timeStart)*1000).'ms';
        }

        $this->output->writeln('<info>Part '.$part.' generated the answer'.$timeTotal.': '.$return.'</>');
    }

    private function loadPayload()
    {
        $reflector = new \ReflectionClass(static::class);
        $dir = dirname($reflector->getFileName());
        $input = $dir.'/input';
        $testDir = $dir.'/tests';

        if (file_exists($input) === false) {
            throw new Exceptions\MissingInputException();
        }

        $this->payload = $this->processPayload(trim(file_get_contents($input)));

        if (file_exists($testDir) === true) {
            $this->loadTestPayload($testDir);
        }
    }

    private function loadTestPayload($dir)
    {
        foreach ($this->parts as $part) {
            $testDir = $dir.'/'.$part;

            if (file_exists($testDir) === true) {
                $tests = scandir($testDir);

                foreach ($tests as $expected) {
                    $testFile = $testDir.'/'.$expected;

                    if (is_file($testFile) === true) {
                        $this->testData[$part][trim(file_get_contents($testFile))] = preg_replace('/\.test.*/', '', $expected);
                    }
                }
            }
        }
    }

    private function missingFunction()
    {
        throw new Exceptions\MissingFunctionException();
    }
}
