<?php

namespace App\Tasks\Achievements;

use App\Tasks\Support\AbstractClearExistingResourcesTask;

class ClearExisting extends AbstractClearExistingResourcesTask
{
    protected function getResources(): array
    {
        return $this->r4nkt->achievements();
    }
}
