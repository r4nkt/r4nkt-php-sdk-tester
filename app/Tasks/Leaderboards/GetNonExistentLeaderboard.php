<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Exceptions\NotFoundException;

class GetNonExistentLeaderboard extends AbstractTask
{
    private $customId;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->r4nkt->leaderboard($this->customId);
    }

    public function passed(): bool
    {
        return ($this->exception instanceof NotFoundException);
    }
}
