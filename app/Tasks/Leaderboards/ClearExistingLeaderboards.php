<?php

namespace App\Tasks\Leaderboards;

use App\Tasks\Support\AbstractClearExistingResourcesTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

class ClearExistingLeaderboards extends AbstractClearExistingResourcesTask
{
    protected function getResources(): ApiResourceCollection
    {
        return $this->r4nkt->leaderboards();
    }
}
