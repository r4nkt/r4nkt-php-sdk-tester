<?php

namespace App\Tasks;

use Exception;
use R4nkt\PhpSdk\R4nkt;

abstract class AbstractTask
{
    protected $exception;

    protected $r4nkt;

    protected $title;

    protected $expectsException;

    public function __construct(R4nkt $r4nkt, string $title = '', bool $expectsException = false)
    {
        $this->r4nkt = $r4nkt;
        $this->title = $title;
        $this->expectsException = $expectsException;
    }

    public function run()
    {
        try {
            $this->runTask();
        } catch (Exception $e) {
            $this->exception = $e;
        }

        return $this;
    }

    abstract protected function runTask();

    public function passed(): bool
    {
        if (! $this->expectsException && $this->exception) {
            dump($this->exception);
            return false;
        }

        return $this->taskPassed();
    }

    abstract protected function taskPassed(): bool;

    public function title(): string
    {
        return $this->title;
    }
}
