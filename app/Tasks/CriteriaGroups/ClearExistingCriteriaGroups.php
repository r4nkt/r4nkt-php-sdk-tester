<?php

namespace App\Tasks\CriteriaGroups;

use App\Tasks\Support\AbstractClearExistingResourcesTask;

class ClearExistingCriteriaGroups extends AbstractClearExistingResourcesTask
{
    protected function getResources(): array
    {
        return $this->r4nkt->criteriaGroups();
    }
}
