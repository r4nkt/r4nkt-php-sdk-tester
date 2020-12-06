<?php

namespace App\Tasks\Players;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class Index extends AbstractTask
{
    private $expectedCustomIds;

    private $players;

    public function __construct(Collection $expectedCustomIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->expectedCustomIds = $expectedCustomIds;
    }

    protected function runTask()
    {
        $this->players = $this->r4nkt->players();
    }

    protected function taskPassed(): bool
    {
        $actualCustomIds = collect($this->players)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomIds->count())
            && ($this->expectedCustomIds->intersect($actualCustomIds)->count() === $this->expectedCustomIds->count()));
    }
}
