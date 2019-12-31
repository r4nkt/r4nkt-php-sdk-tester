<?php

namespace App\Tasks\Rewards;

use App\Tasks\Support\AbstractClearExistingResourcesTask;

class ClearExisting extends AbstractClearExistingResourcesTask
{
    protected function getResources(): array
    {
        return $this->r4nkt->rewards();
    }
}
