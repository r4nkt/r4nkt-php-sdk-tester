<?php

namespace App\Tasks\Scenarios;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\R4nkt;

class SimpleCustomLeaderboard extends AbstractTask
{
    protected $leaderboardLargerIsBetter;
    protected $leaderboardSmallerIsBetter;

    protected $homer = 'player.multiplayer.leaderboard.homer';
    protected $marge = 'player.multiplayer.leaderboard.marge';
    protected $bart = 'player.multiplayer.leaderboard.bart';
    protected $lisa = 'player.multiplayer.leaderboard.lisa';
    protected $maggie = 'player.multiplayer.leaderboard.maggie';
    protected $abe = 'player.multiplayer.leaderboard.abe';
    protected $mona = 'player.multiplayer.leaderboard.mona';

    protected function runTask()
    {
        $this->leaderboardLargerIsBetter = $this->r4nkt->createLeaderboard([
            'custom_id' => 'simple.custom.leaderboard.larger',
            'name' => 'simple.custom.leaderboard.larger',
            'type' => 'custom',
        ]);
        $this->leaderboardSmallerIsBetter = $this->r4nkt->createLeaderboard([
            'custom_id' => 'simple.custom.leaderboard.smaller',
            'name' => 'simple.custom.leaderboard.smaller',
            'type' => 'custom',
            'ordering' => 'smaller-is-better',
        ]);

        // First, scores for the larger-is-better leaderboard...
        $this->r4nkt->submitPlayerScore($this->homer, $this->leaderboardLargerIsBetter->custom_id, 20);
        $this->r4nkt->submitPlayerScore($this->marge, $this->leaderboardLargerIsBetter->custom_id, 5);

        $this->r4nkt->submitPlayerScore($this->bart, $this->leaderboardLargerIsBetter->custom_id, 10);
        $this->r4nkt->submitPlayerScore($this->lisa, $this->leaderboardLargerIsBetter->custom_id, 10);
        $this->r4nkt->submitPlayerScore($this->maggie, $this->leaderboardLargerIsBetter->custom_id, 10);

        $this->r4nkt->submitPlayerScore($this->abe, $this->leaderboardLargerIsBetter->custom_id, 20);
        $this->r4nkt->submitPlayerScore($this->mona, $this->leaderboardLargerIsBetter->custom_id, 5);

        // Now, the same scores, but for the smaller-is-better leaderboard...
        $this->r4nkt->submitPlayerScore($this->homer, $this->leaderboardSmallerIsBetter->custom_id, 20);
        $this->r4nkt->submitPlayerScore($this->marge, $this->leaderboardSmallerIsBetter->custom_id, 5);

        $this->r4nkt->submitPlayerScore($this->bart, $this->leaderboardSmallerIsBetter->custom_id, 10);
        $this->r4nkt->submitPlayerScore($this->lisa, $this->leaderboardSmallerIsBetter->custom_id, 10);
        $this->r4nkt->submitPlayerScore($this->maggie, $this->leaderboardSmallerIsBetter->custom_id, 10);

        $this->r4nkt->submitPlayerScore($this->abe, $this->leaderboardSmallerIsBetter->custom_id, 20);
        $this->r4nkt->submitPlayerScore($this->mona, $this->leaderboardSmallerIsBetter->custom_id, 5);

        // Expected rankings (zero-based, larger-is-better):
        //  - 0. 20 Homer
        //  - 1. 20 Abe
        //  - 2. 10 Bart
        //  - 3. 10 Lisa
        //  - 4. 10 Maggie
        //  - 5. 5  Marge
        //  - 6. 5  Mona

        // Expected rankings (zero-based, smaller-is-better):
        //  - 0. 5  Marge
        //  - 1. 5  Mona
        //  - 2. 10 Bart
        //  - 3. 10 Lisa
        //  - 4. 10 Maggie
        //  - 5. 20 Homer
        //  - 6. 20 Abe
    }

    protected function taskPassed(): bool
    {
        // Note: getting rankings two different ways...
        $rankingsLarger = $this->leaderboardLargerIsBetter->rankings();
        $rankingsSmaller = $this->r4nkt->leaderboardRankings($this->leaderboardSmallerIsBetter->custom_id);

dump($rankingsLarger);
dump($rankingsSmaller);
return true;
        return count($badges) === 1;
    }
}
