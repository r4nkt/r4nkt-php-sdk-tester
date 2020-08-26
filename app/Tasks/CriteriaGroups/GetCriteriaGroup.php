<?php

namespace App\Tasks\CriteriaGroups;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class GetCriteriaGroup extends AbstractTask
{
    private $customId;

    private $criteriaGroup;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->criteriaGroup = $this->r4nkt->criteriaGroup($this->customId);
    }

    public function passed(): bool
    {
        return ($this->criteriaGroup->custom_id === $this->customId);
    }
}
