<?php

namespace App\Tasks\Actions;

use App\Tasks\Support\AbstractClearExistingResourcesTask;

class ClearExistingActions extends AbstractClearExistingResourcesTask
{
    protected function getResources(): array
    {
        return $this->r4nkt->actions();
    }
}
