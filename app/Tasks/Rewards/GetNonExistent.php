<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Exceptions\NotFoundException;

class GetNonExistent extends AbstractTask
{
    private $customId;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title, true);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->r4nkt->reward($this->customId);
    }

    protected function taskPassed(): bool
    {
        return $this->exception instanceof NotFoundException;
    }
}
