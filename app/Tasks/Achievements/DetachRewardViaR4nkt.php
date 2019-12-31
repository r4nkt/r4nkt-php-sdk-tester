<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class DetachRewardViaR4nkt extends AbstractTask
{
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
        $this->r4nkt->detachRewardFromAchievement($this->customId, $this->customRewardId);
    }

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
