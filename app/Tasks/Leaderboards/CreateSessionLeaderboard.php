<?php

namespace App\Tasks\Leaderboards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class CreateSessionLeaderboard extends AbstractTask
{
    private $leaderboard;
    private $customId;
    private $name;
    private $description;
    private $type = 'session';
    private $customSessionId;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->name = 'name' . uniqid();
        $this->description = 'description' . uniqid();
        $this->customSessionId = 'customSessionId' . uniqid();

        $this->leaderboard = $this->r4nkt->createLeaderboard([
            'custom_id' => $this->customId,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'custom_session_id' => $this->customSessionId,
        ]);
    }

    protected function taskPassed(): bool
    {
        return (($this->leaderboard->custom_id === $this->customId)
            && ($this->leaderboard->name === $this->name)
            && ($this->leaderboard->description === $this->description)
            && ($this->leaderboard->custom_session_id === $this->customSessionId)
            && ($this->leaderboard->type === $this->type));
    }
}
