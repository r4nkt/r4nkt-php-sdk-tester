<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class IndexEmptyCriteria extends IndexCriteria
{
    public function __construct(R4nkt $r4nkt, string $title = '')
    {
        parent::__construct(collect(), $r4nkt, $title);
    }
}
