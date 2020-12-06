<?php

namespace App\Tasks\Scenarios;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\R4nkt;

class ClearAll extends AbstractTask
{
    protected $count;

    protected function runTask()
    {
        do {
            collect($resources = $this->r4nkt->achievements(1, 20, 'with'))->each(function ($resource) {
                $resource->delete();
            });
        } while ($resources->total() > ($resources->to() - $resources->from()));

        $this->deleteResources('actions');
        $this->deleteResources('criteria');
        $this->deleteResources('criteriaGroups');
        $this->deleteResources('leaderboards');
        $this->deleteResources('players');
        $this->deleteResources('rewards');

        $this->count = count($this->r4nkt->achievements(1, 20, 'with'));
        $this->count += count($this->r4nkt->actions());
        $this->count += count($this->r4nkt->criteria());
        $this->count += count($this->r4nkt->criteriaGroups());
        $this->count += count($this->r4nkt->leaderboards());
        $this->count += count($this->r4nkt->players());
        $this->count += count($this->r4nkt->rewards());
    }

    protected function deleteResources(string $resourcesMethod)
    {
        do {
            collect($resources = $this->r4nkt->$resourcesMethod())->each(function ($resource) {
                $resource->delete();
            });
        } while ($resources->total() > $resources->to() - $resources->from());
    }

    protected function taskPassed(): bool
    {
        return $this->count === 0;
    }
}
