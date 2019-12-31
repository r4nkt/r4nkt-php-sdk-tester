<?php

namespace App\Tasks\Leaderboards;

use App\Tasks\Support\AbstractClearExistingResourcesTask;

class ClearExistingLeaderboards extends AbstractClearExistingResourcesTask
{
    protected function getResources(): array
    {
        return $this->r4nkt->leaderboards();
    }
}
