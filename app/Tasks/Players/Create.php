<?php

namespace App\Tasks\Players;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class Create extends AbstractTask
{
    private $player;
    private $customId;
    private $name;
    private $description;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->player = $this->r4nkt->createPlayer([
            'custom_id' => $this->customId,
        ]);
    }

    protected function taskPassed(): bool
    {
        return ($this->player->custom_id === $this->customId);
    }
}
