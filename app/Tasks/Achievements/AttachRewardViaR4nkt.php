<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Reward;

class AttachRewardViaR4nkt extends AbstractTask
{
    private $reward;
    private $customId;
    private $customRewardId;

    public function __construct(string $customId, string $customRewardId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
        $this->customRewardId = $customRewardId;
    }

    protected function runTask()
    {
        $this->reward = $this->r4nkt->attachRewardToAchievement($this->customId, $this->customRewardId);
    }

    protected function taskPassed(): bool
    {
        return $this->reward instanceof Reward;
    }
}
