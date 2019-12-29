<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Leaderboard;

class DeleteLeaderboardViaLeaderboard extends AbstractTask
{
    private $leaderboard;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->leaderboard = new Leaderboard(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->leaderboard->delete();
    }

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
