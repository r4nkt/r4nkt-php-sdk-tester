<?php

namespace App\Tasks\CriteriaGroups;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\CriteriaGroup;

class DeleteCriteriaGroupViaCriteriaGroup extends AbstractTask
{
    private $criteriaGroup;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->criteriaGroup = new CriteriaGroup(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->criteriaGroup->delete();
    }

    protected function taskPassed(): bool
    {
        return true;
    }
}
