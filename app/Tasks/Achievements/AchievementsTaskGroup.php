<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;
use App\Tasks\Rewards\Create as CreateReward;
use App\Tasks\Rewards\ClearExisting as ClearExistingRewards;

class AchievementsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Achievements');

        $this->add(new ClearExisting($r4nkt, 'Clear Existing'));
        $this->add(new ClearExistingRewards($r4nkt, 'Clear Existing Rewards'));
        $this->add(new IndexEmpty($r4nkt, 'Index Empty'));

        $this->add(new CreateReward('reward.a', $r4nkt, 'Create Reward A'));
        $this->add(new CreateReward('reward.b', $r4nkt, 'Create Reward B'));
        $this->add(new CreateReward('reward.c', $r4nkt, 'Create Reward C'));

        $this->add(new Create('achievement.a', $r4nkt, 'Create A'));
        $this->add(new Create('achievement.b', $r4nkt, 'Create B'));
        $this->add(new Create('achievement.c', $r4nkt, 'Create C'));

        $this->add(new AttachRewardViaSelf('achievement.a', 'reward.a', $r4nkt, 'Attach Reward A to Achievement A (via self)'));
        $this->add(new AttachRewardViaSelf('achievement.a', 'reward.b', $r4nkt, 'Attach Reward B to Achievement A (via self)'));
        $this->add(new AttachRewardViaR4nkt('achievement.c', 'reward.c', $r4nkt, 'Attach Reward C to Achievement C (via r4nkt)'));

        $this->add(new IndexRewardsViaR4nkt('achievement.a', collect(['reward.a', 'reward.b']), $r4nkt, 'Index Rewards for Achievement A (via r4nkt)'));
        $this->add(new IndexRewardsViaSelf('achievement.a', collect(['reward.a', 'reward.b']), $r4nkt, 'Index Rewards for Achievement A (via self)'));
        $this->add(new IndexRewardsViaR4nkt('achievement.b', collect(), $r4nkt, 'Index Rewards for Achievement B (via r4nkt)'));
        $this->add(new IndexRewardsViaSelf('achievement.b', collect(), $r4nkt, 'Index Rewards for Achievement B (via self)'));
        $this->add(new IndexRewardsViaR4nkt('achievement.c', collect(['reward.c']), $r4nkt, 'Index Rewards for Achievement C (via r4nkt)'));
        $this->add(new IndexRewardsViaSelf('achievement.c', collect(['reward.c']), $r4nkt, 'Index Rewards for Achievement C (via self)'));

        $this->add(new DetachRewardViaSelf('achievement.a', 'reward.a', $r4nkt, 'Detach Reward A from Achievement A (via self)'));
        $this->add(new DetachRewardViaSelf('achievement.a', 'reward.b', $r4nkt, 'Detach Reward B from Achievement A (via self)'));
        $this->add(new DetachRewardViaR4nkt('achievement.c', 'reward.c', $r4nkt, 'Detach Reward C from Achievement C (via r4nkt)'));

        $this->add(new IndexRewardsViaR4nkt('achievement.a', collect(), $r4nkt, 'Index Rewards for Achievement A (via r4nkt)'));
        $this->add(new IndexRewardsViaR4nkt('achievement.b', collect(), $r4nkt, 'Index Rewards for Achievement B (via r4nkt)'));
        $this->add(new IndexRewardsViaR4nkt('achievement.c', collect(), $r4nkt, 'Index Rewards for Achievement C (via r4nkt)'));

        /** @todo Attach a nonexistent reward. */
        /** @todo Detach a nonexistent reward. */
        /** @todo Index rewards for nonexistent achievement. */

        $this->add(new Index(collect(['achievement.a', 'achievement.b', 'achievement.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new Get('achievement.b', $r4nkt, 'Get B'));
        $this->add(new DeleteViaR4nkt('achievement.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistent('achievement.a', $r4nkt, 'Get Deleted A (achievement.a)'));
        $this->add(new DeleteViaSelf('achievement.b', $r4nkt, 'Delete B (via self)'));
        $this->add(new GetNonExistent('achievement.b', $r4nkt, 'Get Deleted B (achievement.b)'));
        $this->add(new DeleteViaSelf('achievement.c', $r4nkt, 'Delete C (via self)'));
        $this->add(new GetNonExistent('achievement.c', $r4nkt, 'Get Deleted C (achievement.c)'));
    }
}
