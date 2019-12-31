<?php

namespace App\Tasks\CriteriaGroups;

use R4nkt\PhpSdk\R4nkt;
use App\Tasks\TaskGroup;

class CriteriaGroupsTaskGroup extends TaskGroup
{
    public function __construct(R4nkt $r4nkt)
    {
        parent::__construct('CriteriaGroups');

        $this->add(new ClearExistingCriteriaGroups($r4nkt, 'Clear Existing'));
        $this->add(new IndexEmptyCriteriaGroups($r4nkt, 'Index Empty'));
        $this->add(new CreateCriteriaGroup('criteriaGroup.a', $r4nkt, 'Create A'));
        $this->add(new CreateCriteriaGroup('criteriaGroup.b', $r4nkt, 'Create B'));
        $this->add(new CreateCriteriaGroup('criteriaGroup.c', $r4nkt, 'Create C'));
        $this->add(new IndexCriteriaGroups(collect(['criteriaGroup.a', 'criteriaGroup.b', 'criteriaGroup.c']), $r4nkt, 'Index Non-Empty'));
        $this->add(new GetCriteriaGroup('criteriaGroup.b', $r4nkt, 'Get B'));
        $this->add(new DeleteCriteriaGroupViaR4nkt('criteriaGroup.a', $r4nkt, 'Delete A (via r4nkt)'));
        $this->add(new GetNonExistentCriteriaGroup('criteriaGroup.a', $r4nkt, 'Get Deleted A (criteriaGroup.a)'));
        $this->add(new DeleteCriteriaGroupViaCriteriaGroup('criteriaGroup.b', $r4nkt, 'Delete B (via criteriaGroup)'));
        $this->add(new GetNonExistentCriteriaGroup('criteriaGroup.b', $r4nkt, 'Get Deleted B (criteriaGroup.b)'));
        $this->add(new DeleteCriteriaGroupViaCriteriaGroup('criteriaGroup.c', $r4nkt, 'Delete C (via criteriaGroup)'));
        $this->add(new GetNonExistentCriteriaGroup('criteriaGroup.c', $r4nkt, 'Get Deleted C (criteriaGroup.c)'));
    }
}
