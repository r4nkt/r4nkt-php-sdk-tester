<?php

namespace App\Tasks\Achievements;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\AbstractTask;

class IndexEmpty extends Index
{
    public function __construct(R4nkt $r4nkt, string $title = '')
    {
        parent::__construct(collect(), $r4nkt, $title);
    }
}
