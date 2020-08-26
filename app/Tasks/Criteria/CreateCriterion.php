<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class CreateCriterion extends AbstractTask
{
    private $criterion;
    private $customId;
    private $customActionId;
    private $name;
    private $description;

    public function __construct(string $customId, string $customActionId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->customId = $customId;
        $this->customActionId = $customActionId;
    }

    protected function runTask()
    {
        $this->name = 'name' . uniqid();
        $this->description = 'description' . uniqid();

        $this->criterion = $this->r4nkt->createCriterion([
            'custom_id' => $this->customId,
            'custom_action_id' => $this->customActionId,
            'name' => $this->name,
            'description' => $this->description,
        ]);
    }

    public function passed(): bool
    {
        return (($this->criterion->custom_id === $this->customId)
            && ($this->criterion->name === $this->name)
            && ($this->criterion->description === $this->description));
    }
}
