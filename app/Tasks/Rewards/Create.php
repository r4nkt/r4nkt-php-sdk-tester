<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class Create extends AbstractTask
{
    private $reward;
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
        $this->name = 'name' . uniqid();
        $this->description = 'description' . uniqid();

        $this->reward = $this->r4nkt->createReward([
            'custom_id' => $this->customId,
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }

    public function passed(): bool
    {
        return (($this->reward->customId === $this->customId)
            && ($this->reward->name === $this->name)
            && ($this->reward->description === $this->description));
    }
}
