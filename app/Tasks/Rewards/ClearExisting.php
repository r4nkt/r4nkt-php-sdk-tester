<?php

namespace App\Tasks\Rewards;

use App\Tasks\Support\AbstractClearExistingResourcesTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

class ClearExisting extends AbstractClearExistingResourcesTask
{
    protected function getResources(): ApiResourceCollection
    {
        return $this->r4nkt->rewards();
    }
}
