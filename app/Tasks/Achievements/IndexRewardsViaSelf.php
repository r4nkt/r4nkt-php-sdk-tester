<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;
use R4nkt\PhpSdk\Resources\Achievement;

class IndexRewardsViaSelf extends AbstractTask
{
    private $expectedCustomRewardIds;

    private $achievement;

    private $rewards;

    public function __construct(string $customId, Collection $expectedCustomRewardIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->achievement = new Achievement(['custom_id' => $customId], $r4nkt);
        $this->expectedCustomRewardIds = $expectedCustomRewardIds;
    }

    protected function runTask()
    {
        $this->rewards = $this->achievement->rewards();
    }

    public function passed(): bool
    {
        $actualCustomIds = collect($this->rewards)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomRewardIds->count())
            && ($this->expectedCustomRewardIds->intersect($actualCustomIds)->count() === $this->expectedCustomRewardIds->count()));
    }
}
