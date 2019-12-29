<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class AchievementsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Achievements');

        $this->add(new IndexEmptyAchievements($r4nkt, 'Index Empty'));
        $this->add(new CreateAchievement('achievement.a', $r4nkt, 'Create A'));
        $this->add(new CreateAchievement('achievement.b', $r4nkt, 'Create B'));
        $this->add(new CreateAchievement('achievement.c', $r4nkt, 'Create C'));
        $this->add(new IndexAchievements(collect(['achievement.a', 'achievement.b', 'achievement.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetAchievement('achievement.b', $r4nkt, 'Get B'));
        $this->add(new DeleteAchievementViaR4nkt('achievement.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentAchievement('achievement.a', $r4nkt, 'Get Deleted A (achievement.a)'));
        $this->add(new DeleteAchievementViaAchievement('achievement.b', $r4nkt, 'Delete B (via achievement)'));
        $this->add(new GetNonExistentAchievement('achievement.b', $r4nkt, 'Get Deleted B (achievement.b)'));
        $this->add(new DeleteAchievementViaAchievement('achievement.c', $r4nkt, 'Delete C (via achievement)'));
        $this->add(new GetNonExistentAchievement('achievement.c', $r4nkt, 'Get Deleted C (achievement.c)'));
    }
}
