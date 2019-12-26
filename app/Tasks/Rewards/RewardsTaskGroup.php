<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class RewardsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Rewards');

        $this->add(new IndexEmptyRewards($r4nkt, 'Index Empty'));
        $this->add(new CreateReward('reward.a', $r4nkt, 'Create A'));
        $this->add(new CreateReward('reward.b', $r4nkt, 'Create B'));
        $this->add(new CreateReward('reward.c', $r4nkt, 'Create C'));
        $this->add(new IndexRewards(collect(['reward.a', 'reward.b', 'reward.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetReward('reward.b', $r4nkt, 'Get B'));
        $this->add(new DeleteRewardViaR4nkt('reward.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentReward('reward.a', $r4nkt, 'Get Deleted A (reward.a)'));
        $this->add(new DeleteRewardViaReward('reward.b', $r4nkt, 'Delete B (via reward)'));
        $this->add(new GetNonExistentReward('reward.b', $r4nkt, 'Get Deleted B (reward.b)'));
        $this->add(new DeleteRewardViaReward('reward.c', $r4nkt, 'Delete C (via reward)'));
        $this->add(new GetNonExistentReward('reward.c', $r4nkt, 'Get Deleted C (reward.c)'));
    }
}
