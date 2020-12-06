<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class IndexLeaderboards extends AbstractTask
{
    private $expectedCustomIds;

    private $leaderboards;

    public function __construct(Collection $expectedCustomIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->expectedCustomIds = $expectedCustomIds;
    }

    protected function runTask()
    {
        $this->leaderboards = $this->r4nkt->leaderboards();
    }

    protected function taskPassed(): bool
    {
        $actualCustomIds = collect($this->leaderboards)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomIds->count())
            && ($this->expectedCustomIds->intersect($actualCustomIds)->count() === $this->expectedCustomIds->count()));
    }
}
