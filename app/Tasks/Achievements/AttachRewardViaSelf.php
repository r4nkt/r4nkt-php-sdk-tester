<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Reward;
use R4nkt\PhpSdk\Resources\Achievement;

class AttachRewardViaSelf extends AbstractTask
{
    private $achievement;
    private $reward;
    private $customRewardId;

    public function __construct(string $customId, string $customRewardId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->achievement = new Achievement(['custom_id' => $customId], $r4nkt);
        $this->customRewardId = $customRewardId;
    }

    protected function runTask()
    {
        $this->reward = $this->achievement->attachReward($this->customRewardId);
    }

    public function passed(): bool
    {
        return (($this->exception === null)
            && ($this->reward instanceof Reward));
    }
}
