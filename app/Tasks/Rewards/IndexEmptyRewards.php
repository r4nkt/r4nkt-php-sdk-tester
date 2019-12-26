<?php

namespace App\Tasks\Rewards;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class IndexEmptyRewards extends IndexRewards
{
    public function __construct(R4nkt $r4nkt, string $title = '')
    {
        parent::__construct(collect(), $r4nkt, $title);
    }
}
