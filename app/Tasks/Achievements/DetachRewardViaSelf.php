<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Achievement;

class DetachRewardViaSelf extends AbstractTask
{
    private $achievement;
    private $customRewardId;

    public function __construct(string $customId, string $customRewardId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->achievement = new Achievement(['custom_id' => $customId], $r4nkt);
        $this->customRewardId = $customRewardId;
    }

    protected function runTask()
    {
        $this->achievement->detachReward($this->customRewardId);
    }

    protected function taskPassed(): bool
    {
        return true;
    }
}
