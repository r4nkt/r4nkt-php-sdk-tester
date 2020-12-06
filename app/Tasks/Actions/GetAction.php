<?php

namespace App\Tasks\Actions;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class GetAction extends AbstractTask
{
    private $customId;

    private $action;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->action = $this->r4nkt->action($this->customId);
    }

    protected function taskPassed(): bool
    {
        return ($this->action->custom_id === $this->customId);
    }
}
