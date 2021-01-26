<?php

namespace App\Tasks\Leaderboards;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Exceptions\ValidationException;
use R4nkt\PhpSdk\R4nkt;

class CreateSecondStandardLeaderboard extends AbstractTask
{
    private $customId;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title, true);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $name = 'name' . uniqid();

        $this->r4nkt->createLeaderboard([
            'custom_id' => $this->customId,
            'name' => $name,
        ]);
    }

    protected function taskPassed(): bool
    {
        return $this->exception instanceof ValidationException;
    }
}
