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
        $this->add(new CreateStandardLeaderboard('leaderboard.a', $r4nkt, 'Create A (standard)'));
        $this->add(new CreateSecondStandardLeaderboard('leaderboard.b', $r4nkt, 'Create B (2nd standard, not allowed)'));
        $this->add(new CreateSessionLeaderboard('leaderboard.c', $r4nkt, 'Create C (session)'));
        $this->add(new CreateSessionLeaderboard('leaderboard.d', $r4nkt, 'Create D (session)'));
        $this->add(new IndexEmptyLeaderboardRankings('leaderboard.c', $r4nkt, 'Index Empty Rankings (via r4nkt)'));

        $this->add(new IndexLeaderboards(collect(['leaderboard.a', 'leaderboard.c', 'leaderboard.d']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetLeaderboard('leaderboard.c', $r4nkt, 'Get C'));
        $this->add(new DeleteLeaderboardViaR4nkt('leaderboard.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentLeaderboard('leaderboard.a', $r4nkt, 'Get Deleted A (leaderboard.a)'));
        $this->add(new DeleteLeaderboardViaLeaderboard('leaderboard.c', $r4nkt, 'Delete C (via leaderboard)'));
        $this->add(new GetNonExistentLeaderboard('leaderboard.c', $r4nkt, 'Get Deleted C (leaderboard.c)'));
        $this->add(new DeleteLeaderboardViaR4nkt('leaderboard.d', $r4nkt, 'Delete D (via r4nkt)'));
        $this->add(new GetNonExistentLeaderboard('leaderboard.d', $r4nkt, 'Get Deleted D (leaderboard.b)'));
    }
}
