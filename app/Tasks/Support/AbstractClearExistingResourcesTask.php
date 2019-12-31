<?php

namespace App\Tasks\Support;

use App\Tasks\AbstractTask;

abstract class AbstractClearExistingResourcesTask extends AbstractTask
{
    protected function runTask()
    {
        collect($this->getResources())->each(function ($resource) {
            $resource->delete();
        });
    }

    abstract protected function getResources(): array;

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
