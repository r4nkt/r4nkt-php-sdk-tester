<?php

namespace App\Tasks\Criteria;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;
use App\Tasks\Actions\CreateAction;
use App\Tasks\Actions\DeleteActionViaR4nkt;

class CriteriaTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('Criteria');

        $this->add(new CreateAction('action.a', $r4nkt, 'Create Action A'));
        $this->add(new CreateAction('action.b', $r4nkt, 'Create Action B'));
        $this->add(new CreateAction('action.c', $r4nkt, 'Create Action C'));

        $this->add(new IndexEmptyCriteria($r4nkt, 'Index Empty'));
        $this->add(new CreateCriterion('criterion.a', 'action.a', $r4nkt, 'Create A'));
        $this->add(new CreateCriterion('criterion.b', 'action.b', $r4nkt, 'Create B'));
        $this->add(new CreateCriterion('criterion.c', 'action.c', $r4nkt, 'Create C'));
        $this->add(new IndexCriteria(collect(['criterion.a', 'criterion.b', 'criterion.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetCriterion('criterion.b', $r4nkt, 'Get B'));
        $this->add(new DeleteCriterionViaR4nkt('criterion.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentCriterion('criterion.a', $r4nkt, 'Get Deleted A (criterion.a)'));
        $this->add(new DeleteCriterionViaCriterion('criterion.b', $r4nkt, 'Delete B (via criterion)'));
        $this->add(new GetNonExistentCriterion('criterion.b', $r4nkt, 'Get Deleted B (criterion.b)'));
        $this->add(new DeleteCriterionViaCriterion('criterion.c', $r4nkt, 'Delete C (via criterion)'));
        $this->add(new GetNonExistentCriterion('criterion.c', $r4nkt, 'Get Deleted C (criterion.c)'));

        $this->add(new DeleteActionViaR4nkt('action.a', $r4nkt, 'Delete Action A (via r4nkt)'));
        $this->add(new DeleteActionViaR4nkt('action.b', $r4nkt, 'Delete Action B (via r4nkt)'));
        $this->add(new DeleteActionViaR4nkt('action.c', $r4nkt, 'Delete Action C (via r4nkt)'));
    }
}
