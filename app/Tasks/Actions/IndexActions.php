<?php

namespace App\Tasks\Actions;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class IndexActions extends AbstractTask
{
    private $expectedCustomIds;

    private $actions;

    public function __construct(Collection $expectedCustomIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->expectedCustomIds = $expectedCustomIds;
    }

    protected function runTask()
    {
        $this->actions = $this->r4nkt->actions();
    }

    protected function taskPassed(): bool
    {
        $actualCustomIds = collect($this->actions)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomIds->count())
            && ($this->expectedCustomIds->intersect($actualCustomIds)->count() === $this->expectedCustomIds->count()));
    }
}
