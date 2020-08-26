<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class GetLeaderboard extends AbstractTask
{
    private $customId;

    private $leaderboard;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->leaderboard = $this->r4nkt->leaderboard($this->customId);
    }

    public function passed(): bool
    {
        return ($this->leaderboard->custom_id === $this->customId);
    }
}
