<?php

namespace App\Tasks\Criteria;

use App\Tasks\Support\AbstractClearExistingResourcesTask;

class ClearExistingCriteria extends AbstractClearExistingResourcesTask
{
    protected function getResources(): array
    {
        return $this->r4nkt->criteria();
    }
}
