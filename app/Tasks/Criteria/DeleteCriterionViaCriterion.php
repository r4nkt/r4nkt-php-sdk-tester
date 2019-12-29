<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\Resources\Criterion;

class DeleteCriterionViaCriterion extends AbstractTask
{
    private $criterion;

    public function __construct(string $customId, R4nkt $r4nkt, string $title = '')
    {
        parent::__construct($r4nkt, $title);

        $this->criterion = new Criterion(['custom_id' => $customId], $r4nkt);
    }

    protected function runTask()
    {
        $this->criterion->delete();
    }

    public function passed(): bool
    {
        return ($this->exception === null);
    }
}
