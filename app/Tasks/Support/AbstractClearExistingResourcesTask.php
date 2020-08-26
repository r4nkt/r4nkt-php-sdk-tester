<?php

namespace App\Tasks\Support;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\ApiResourceCollection;

abstract class AbstractClearExistingResourcesTask extends AbstractTask
{
    protected function runTask()
    {
        collect($this->getResources())->each(function ($resource) {
            $resource->delete();
        });
    }

    abstract protected function getResources(): ApiResourceCollection;

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
