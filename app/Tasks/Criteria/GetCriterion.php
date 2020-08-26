<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class GetCriterion extends AbstractTask
{
    private $customId;

    private $criterion;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->criterion = $this->r4nkt->criterion($this->customId);
    }

    public function passed(): bool
    {
        return ($this->criterion->custom_id === $this->customId);
    }
}
