<?php

namespace App\Tasks\CriteriaGroups;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class IndexEmptyCriteriaGroups extends IndexCriteriaGroups
{
    public function __construct(R4nkt $r4nkt, string $title = '')
    {
        parent::__construct(collect(), $r4nkt, $title);
    }
}
