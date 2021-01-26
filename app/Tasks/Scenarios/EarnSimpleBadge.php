<?php

namespace App\Tasks\Scenarios;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\R4nkt;

class EarnSimpleBadge extends AbstractTask
{
    protected function runTask()
    {
        $this->r4nkt->reportActivity('player.earn.simple.badge', 'action.slay.a.red.dragon');
        sleep(3);
    }

    protected function taskPassed(): bool
    {
        $badges = $this->r4nkt->playerBadges('player.earn.simple.badge');

        return ((count($badges) === 1) && ($badges[0]->custom_achievement_id === 'achievement.slay.a.red.dragon'));
    }
}
