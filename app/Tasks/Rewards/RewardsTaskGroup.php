<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class RewardsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Rewards');

        $this->add(new ClearExisting($r4nkt, 'Clear Existing'));
        $this->add(new IndexEmpty($r4nkt, 'Index Empty'));
        $this->add(new Create('reward.a', $r4nkt, 'Create A'));
        $this->add(new Create('reward.b', $r4nkt, 'Create B'));
        $this->add(new Create('reward.c', $r4nkt, 'Create C'));
        $this->add(new Index(collect(['reward.a', 'reward.b', 'reward.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new Get('reward.b', $r4nkt, 'Get B'));
        $this->add(new DeleteViaR4nkt('reward.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistent('reward.a', $r4nkt, 'Get Deleted A (reward.a)'));
        $this->add(new DeleteViaSelf('reward.b', $r4nkt, 'Delete B (via reward)'));
        $this->add(new GetNonExistent('reward.b', $r4nkt, 'Get Deleted B (reward.b)'));
        $this->add(new DeleteViaSelf('reward.c', $r4nkt, 'Delete C (via reward)'));
        $this->add(new GetNonExistent('reward.c', $r4nkt, 'Get Deleted C (reward.c)'));
    }
}
