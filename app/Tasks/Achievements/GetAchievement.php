<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class GetAchievement extends AbstractTask
{
    private $customId;

    private $achievement;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->achievement = $this->r4nkt->achievement($this->customId);
    }

    public function passed(): bool
    {
        return ($this->achievement->customId === $this->customId);
    }
}
