<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Achievement;

class UpdateViaSelf extends AbstractTask
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
        $achievement = new Achievement(['custom_id' => $this->customId], $this->r4nkt);

        $this->name = 'name' . uniqid();
        $this->description = 'description' . uniqid();

        $this->achievement = $achievement->update([
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }

    protected function taskPassed(): bool
    {
        return (($this->achievement->custom_id === $this->customId)
            && ($this->achievement->name === $this->name)
            && ($this->achievement->description === $this->description));
    }
}
