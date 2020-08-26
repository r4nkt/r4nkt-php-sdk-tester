<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class LeaderboardsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Leaderboards');

        $this->add(new ClearExistingLeaderboards($r4nkt, 'Clear Existing'));
        $this->add(new IndexEmptyLeaderboards($r4nkt, 'Index Empty'));
        $this->add(new CreateLeaderboard('leaderboard.a', $r4nkt, 'Create A'));
        $this->add(new CreateLeaderboard('leaderboard.b', $r4nkt, 'Create B'));
        $this->add(new CreateLeaderboard('leaderboard.c', $r4nkt, 'Create C'));
        $this->add(new IndexEmptyLeaderboardRankings('leaderboard.c', $r4nkt, 'Index Empty Rankings (via r4nkt)'));

        $this->add(new IndexLeaderboards(collect(['leaderboard.a', 'leaderboard.b', 'leaderboard.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetLeaderboard('leaderboard.b', $r4nkt, 'Get B'));
        $this->add(new DeleteLeaderboardViaR4nkt('leaderboard.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentLeaderboard('leaderboard.a', $r4nkt, 'Get Deleted A (leaderboard.a)'));
        $this->add(new DeleteLeaderboardViaLeaderboard('leaderboard.b', $r4nkt, 'Delete B (via leaderboard)'));
        $this->add(new GetNonExistentLeaderboard('leaderboard.b', $r4nkt, 'Get Deleted B (leaderboard.b)'));
        $this->add(new DeleteLeaderboardViaLeaderboard('leaderboard.c', $r4nkt, 'Delete C (via leaderboard)'));
        $this->add(new GetNonExistentLeaderboard('leaderboard.c', $r4nkt, 'Get Deleted C (leaderboard.c)'));
    }
}
