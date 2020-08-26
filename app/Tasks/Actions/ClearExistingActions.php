<?php

namespace App\Tasks\Actions;

use App\Tasks\Support\AbstractClearExistingResourcesTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

class ClearExistingActions extends AbstractClearExistingResourcesTask
{
    protected function getResources(): ApiResourceCollection
    {
        return $this->r4nkt->actions();
    }
}
