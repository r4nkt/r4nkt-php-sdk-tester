<?php

namespace App\Tasks\Criteria;

use App\Tasks\Support\AbstractClearExistingResourcesTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

class ClearExistingCriteria extends AbstractClearExistingResourcesTask
{
    protected function getResources(): ApiResourceCollection
    {
        return $this->r4nkt->criteria();
    }
}
