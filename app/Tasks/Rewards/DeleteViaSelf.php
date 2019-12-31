<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Reward;

class DeleteViaSelf extends AbstractTask
{
    private $reward;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->reward = new Reward(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->reward->delete();
    }

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
