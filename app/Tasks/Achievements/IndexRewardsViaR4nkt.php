<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class IndexRewardsViaR4nkt extends AbstractTask
{
    private $customId;

    private $expectedCustomRewardIds;

    private $rewards;

    public function __construct(string $customId, Collection $expectedCustomRewardIds, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
        $this->expectedCustomRewardIds = $expectedCustomRewardIds;
    }

    protected function runTask()
    {
        $this->rewards = $this->r4nkt->achievementRewards($this->customId);
    }

    public function passed(): bool
    {
        $actualCustomIds = collect($this->rewards)->pluck('custom_id');

        return (($actualCustomIds->count() === $this->expectedCustomRewardIds->count())
            && ($this->expectedCustomRewardIds->intersect($actualCustomIds)->count() === $this->expectedCustomRewardIds->count()));
    }
}
