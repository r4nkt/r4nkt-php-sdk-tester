<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Achievement;

class DeleteAchievementViaAchievement extends AbstractTask
{
    private $achievement;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->achievement = new Achievement(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->achievement->delete();
    }

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
