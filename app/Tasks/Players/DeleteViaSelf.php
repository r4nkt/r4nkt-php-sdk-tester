<?php

namespace App\Tasks\Players;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Player;

class DeleteViaSelf extends AbstractTask
{
    private $player;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->player = new Player(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->player->delete();
    }

    protected function taskPassed(): bool
    {
        return true;
    }
}
