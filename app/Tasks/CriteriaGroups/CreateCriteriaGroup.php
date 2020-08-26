<?php

namespace App\Tasks\CriteriaGroups;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class CreateCriteriaGroup extends AbstractTask
{
    private $criteriaGroup;
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

        $this->criteriaGroup = $this->r4nkt->createCriteriaGroup([
            'custom_id' => $this->customId,
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }

    public function passed(): bool
    {
        return (($this->criteriaGroup->custom_id === $this->customId)
            && ($this->criteriaGroup->name === $this->name)
            && ($this->criteriaGroup->description === $this->description));
    }
}
