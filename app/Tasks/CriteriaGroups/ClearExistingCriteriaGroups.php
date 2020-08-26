<?php

namespace App\Tasks\CriteriaGroups;

use App\Tasks\Support\AbstractClearExistingResourcesTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

class ClearExistingCriteriaGroups extends AbstractClearExistingResourcesTask
{
    protected function getResources(): ApiResourceCollection
    {
        return $this->r4nkt->criteriaGroups();
    }
}
