<?php

namespace App\Tasks\Scenarios;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class ScenariosTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Scenarios');

        $this->add(new ClearAll($r4nkt, 'Clear All'));
        $this->add(new PrepGame($r4nkt, 'Prep Game'));
        $this->add(new EarnSimpleBadge($r4nkt, 'Earn Simple Badge'));
        $this->add(new EarnComplexBadge($r4nkt, 'Earn Complex Badge'));
        $this->add(new SimpleCustomLeaderboard($r4nkt, 'Simple Custom Leaderboard'));
        // $this->add(new IndexEmpty($r4nkt, 'Index Empty'));
        // $this->add(new Create('reward.a', $r4nkt, 'Create A'));
        // $this->add(new Create('reward.b', $r4nkt, 'Create B'));
        // $this->add(new Create('reward.c', $r4nkt, 'Create C'));
        // $this->add(new Index(collect(['reward.a', 'reward.b', 'reward.c']), $r4nkt, 'Index Non-Empty'));
        // $this->add(new Get('reward.b', $r4nkt, 'Get B'));
        // $this->add(new DeleteViaR4nkt('reward.a', $r4nkt, 'Delete A (via r4nkt)'));
        // $this->add(new GetNonExistent('reward.a', $r4nkt, 'Get Deleted A (reward.a)'));
        // $this->add(new DeleteViaSelf('reward.b', $r4nkt, 'Delete B (via reward)'));
        // $this->add(new GetNonExistent('reward.b', $r4nkt, 'Get Deleted B (reward.b)'));
        // $this->add(new DeleteViaSelf('reward.c', $r4nkt, 'Delete C (via reward)'));
        // $this->add(new GetNonExistent('reward.c', $r4nkt, 'Get Deleted C (reward.c)'));
    }
}
