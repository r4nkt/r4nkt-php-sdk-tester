<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use Illuminate\Support\Collection;

class IndexEmptyLeaderboardRankings extends AbstractTask
{
    private $customId;

    private $rankings;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->rankings = $this->r4nkt->leaderboardRankings($this->customId);
    }

    public function passed(): bool
    {
        return (count($this->rankings) === 0);
    }
}
