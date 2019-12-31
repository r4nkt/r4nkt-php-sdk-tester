<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class Create extends AbstractTask
{
    private $achievement;
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

        $this->achievement = $this->r4nkt->createAchievement([
            'custom_id' => $this->customId,
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }

    public function passed(): bool
    {
        return (($this->achievement->customId === $this->customId)
            && ($this->achievement->name === $this->name)
            && ($this->achievement->description === $this->description));
    }
}
