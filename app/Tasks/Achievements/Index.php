<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class Index extends AbstractTask
{
    private $expectedCustomIds;

    private $achievements;

    public function __construct(Collection $expectedCustomIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->expectedCustomIds = $expectedCustomIds;
    }

    protected function runTask()
    {
        $this->achievements = $this->r4nkt->achievements();
    }

    public function passed(): bool
    {
        $actualCustomIds = collect($this->achievements)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomIds->count())
            && ($this->expectedCustomIds->intersect($actualCustomIds)->count() === $this->expectedCustomIds->count()));
    }
}
