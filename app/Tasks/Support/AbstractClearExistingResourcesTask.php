<?php

namespace App\Tasks\Support;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

abstract class AbstractClearExistingResourcesTask extends AbstractTask
{
    protected function runTask()
    {
        do {
            collect($resources = $this->getResources())->each(function ($resource) {
                $resource->delete();
            });
        } while ($resources->total() > ($resources->to() - $resources->from()));
    }

    abstract protected function getResources(): ApiResourceCollection;

    protected function taskPassed(): bool
    {
        return true;
    }
}
