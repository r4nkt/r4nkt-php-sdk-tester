<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Exceptions\NotFoundException;

class GetNonExistentCriterion extends AbstractTask
{
    private $customId;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title, true);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->r4nkt->criterion($this->customId);
    }

    protected function taskPassed(): bool
    {
        return $this->exception instanceof NotFoundException;
    }
}
