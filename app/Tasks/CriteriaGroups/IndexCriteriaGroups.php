<?php

namespace App\Tasks\CriteriaGroups;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class IndexCriteriaGroups extends AbstractTask
{
    private $expectedCustomIds;

    private $criteriaGroups;

    public function __construct(Collection $expectedCustomIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->expectedCustomIds = $expectedCustomIds;
    }

    protected function runTask()
    {
        $this->criteriaGroups = $this->r4nkt->criteriaGroups();
    }

    public function passed(): bool
    {
        $actualCustomIds = collect($this->criteriaGroups)->pluck('customId');

        return (($actualCustomIds->count() === $this->expectedCustomIds->count())
            && ($this->expectedCustomIds->intersect($actualCustomIds)->count() === $this->expectedCustomIds->count()));
    }
}
