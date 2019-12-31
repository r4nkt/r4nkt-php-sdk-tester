<?php

namespace App\Tasks\Actions;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class ActionsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Actions');

        $this->add(new ClearExistingActions($r4nkt, 'Clear Existing'));
        $this->add(new IndexEmptyActions($r4nkt, 'Index Empty'));
        $this->add(new CreateAction('action.a', $r4nkt, 'Create A'));
        $this->add(new CreateAction('action.b', $r4nkt, 'Create B'));
        $this->add(new CreateAction('action.c', $r4nkt, 'Create C'));
        $this->add(new IndexActions(collect(['action.a', 'action.b', 'action.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetAction('action.b', $r4nkt, 'Get B'));
        $this->add(new DeleteActionViaR4nkt('action.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentAction('action.a', $r4nkt, 'Get Deleted A (action.a)'));
        $this->add(new DeleteActionViaAction('action.b', $r4nkt, 'Delete B (via action)'));
        $this->add(new GetNonExistentAction('action.b', $r4nkt, 'Get Deleted B (action.b)'));
        $this->add(new DeleteActionViaAction('action.c', $r4nkt, 'Delete C (via action)'));
        $this->add(new GetNonExistentAction('action.c', $r4nkt, 'Get Deleted C (action.c)'));
    }
}
