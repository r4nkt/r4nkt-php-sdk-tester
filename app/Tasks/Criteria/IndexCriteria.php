<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class IndexCriteria extends AbstractTask
{
    private $expectedCustomIds;

    private $criteria;

    public function __construct(Collection $expectedCustomIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->expectedCustomIds = $expectedCustomIds;
    }

    protected function runTask()
    {
        $this->criteria = $this->r4nkt->criteria();
    }

    public function passed(): bool
    {
        $actualCustomIds = collect($this->criteria)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomIds->count())
            && ($this->expectedCustomIds->intersect($actualCustomIds)->count() === $this->expectedCustomIds->count()));
    }
}
