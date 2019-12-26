<?php

namespace App\Tasks;

use Exception;
use R4nkt\PhpSdk\R4nkt;

abstract class AbstractTask
{
    protected $exception;

    protected $r4nkt;

    protected $title;

    public function __construct(R4nkt $r4nkt, string $title = '')
    {
        $this->r4nkt = $r4nkt;
        $this->title = $title;
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

    abstract public function passed(): bool;

    public function title(): string
    {
        return $this->title;
    }
}
