<?php

namespace App\Tasks\Players;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class PlayersTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Players');

        $this->add(new ClearExisting($r4nkt, 'Clear Existing'));
        $this->add(new IndexEmpty($r4nkt, 'Index Empty'));
        $this->add(new Create('player.a', $r4nkt, 'Create A'));
        $this->add(new Create('player.b', $r4nkt, 'Create B'));
        $this->add(new Create('player.c', $r4nkt, 'Create C'));
        $this->add(new Index(collect(['player.a', 'player.b', 'player.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new Get('player.b', $r4nkt, 'Get B'));
        $this->add(new DeleteViaR4nkt('player.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistent('player.a', $r4nkt, 'Get Deleted A (player.a)'));
        $this->add(new DeleteViaSelf('player.b', $r4nkt, 'Delete B (via player)'));
        $this->add(new GetNonExistent('player.b', $r4nkt, 'Get Deleted B (player.b)'));
        $this->add(new DeleteViaSelf('player.c', $r4nkt, 'Delete C (via player)'));
        $this->add(new GetNonExistent('player.c', $r4nkt, 'Get Deleted C (player.c)'));
    }
}
