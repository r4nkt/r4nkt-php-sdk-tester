<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class Get extends AbstractTask
{
    private $customId;

    private $reward;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
    }

    protected function runTask()
    {
        $this->reward = $this->r4nkt->reward($this->customId);
    }

    public function passed(): bool
    {
        return ($this->reward->custom_id === $this->customId);
    }
}
