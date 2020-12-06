<?php

namespace App\Tasks\Actions;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Action;

class DeleteActionViaAction extends AbstractTask
{
    private $action;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->action = new Action(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->action->delete();
    }

    protected function taskPassed(): bool
    {
        return true;
    }
}
