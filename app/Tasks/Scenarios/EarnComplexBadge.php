<?php

namespace App\Tasks\Scenarios;

use App\Tasks\AbstractTask;
use R4nkt\PhpSdk\R4nkt;

class EarnComplexBadge extends AbstractTask
{
    protected $playerId = 'player.earn.complex.badge';

    protected function runTask()
    {
        // criteria.group.master.player complete when the following criterion
        // is complete:
        //  - criterion.complete.quest
        // along with *both* of the following criteria groups:
        //  - criteria.group.display.of.excellence
        //  - criteria.group.slayer.of.legends
        $this->r4nkt->reportActivity($this->playerId, 'action.complete.quest');

        // criteria.group.display.of.excellence complete when *any one* of the
        // following criteria groups are complete:
        //  - criteria.group.tomb.raider
        //  - criteria.group.dungeon.destroyer
        //  - criteria.group.thief.extraordinaire
        //  - criteria.group.solver.of.riddles

        // criteria.group.tomb.raider
        //  - criterion.find.50.secret.rooms
        //  - criterion.open.100.chests
        $this->r4nkt->reportActivity($this->playerId, 'action.find.secret.room', 50);
        $this->r4nkt->reportActivity($this->playerId, 'action.open.chest', 100);

        // criteria.group.dungeon.destroyer
        //  - criterion.smash.5.doors
        //  - criterion.break.100.breakables
        $this->r4nkt->reportActivity($this->playerId, 'action.smash.door', 5);
        $this->r4nkt->reportActivity($this->playerId, 'action.break.breakable', 100);

        // criteria.group.thief.extraordinaire
        //  - criterion.detect.5.traps
        //  - criterion.disarm.5.traps
        $this->r4nkt->reportActivity($this->playerId, 'action.detect.trap', 5);
        $this->r4nkt->reportActivity($this->playerId, 'action.disarm.trap', 5);

        // criteria.group.group.solver.of.riddles
        //  - criterion.solve.water.chamber.puzzle
        //  - criterion.solve.lava.field.puzzle
        //  - criterion.solve.clockworks.puzzle
        //  - criterion.solve.five.doors.puzzle
        $this->r4nkt->reportActivity($this->playerId, 'action.solve.water.chamber.puzzle');
        $this->r4nkt->reportActivity($this->playerId, 'action.solve.lava.field.puzzle');
        $this->r4nkt->reportActivity($this->playerId, 'action.solve.clockworks.puzzle');
        $this->r4nkt->reportActivity($this->playerId, 'action.solve.five.doors.puzzle');

        // criteria.group.slayer.of.legends complete when *all* of the
        // following criteria groups are complete:
        //  - criteria.group.queen.slayer
        //  - criteria.group.monster.slayer
        //  - criteria.group.worm.slayer

        // criteria.group.queen.slayer
        //  - criterion.defeat.ethereal.queen.as.cleric
        //  - criterion.defeat.ethereal.queen.as.rogue
        //  - criterion.defeat.ethereal.queen.as.warrior
        //  - criterion.defeat.ethereal.queen.as.wizard
        $this->r4nkt->reportActivity($this->playerId, 'action.defeat.ethereal.queen.as.cleric');
        $this->r4nkt->reportActivity($this->playerId, 'action.defeat.ethereal.queen.as.rogue');
        $this->r4nkt->reportActivity($this->playerId, 'action.defeat.ethereal.queen.as.warrior');
        $this->r4nkt->reportActivity($this->playerId, 'action.defeat.ethereal.queen.as.wizard');

        // criteria.group.monster.slayer
        //  - criterion.slay.100.champions
        //  - criterion.dodge.500.attacks
        //  - criterion.deal.100.critical.strikes
        $this->r4nkt->reportActivity($this->playerId, 'action.slay.champion', 100);
        $this->r4nkt->reportActivity($this->playerId, 'action.dodge.attack', 500);
        $this->r4nkt->reportActivity($this->playerId, 'action.deal.critical.strike', 100);

        // criteria.group.worm.slayer
        //  - criterion.slay.a.red.dragon
        //  - criterion.slay.hydra
        $this->r4nkt->reportActivity($this->playerId, 'action.slay.a.red.dragon');
        $this->r4nkt->reportActivity($this->playerId, 'action.slay.hydra');

        sleep(3);
    }

    protected function taskPassed(): bool
    {
        $badges = $this->r4nkt->playerBadges($this->playerId);

        // achievement.winner
        // achievement.sherlock
        // achievement.jack.sparrow
        // achievement.doorman
        // achievement.bull.in.china.shop
        // achievement.caution
        // achievement.extreme.caution
        // achievement.sir.traps.a.lot
        // achievement.smooth.operator
        // achievement.puzzler
        // achievement.master.puzzler
        // achievement.true.cleric
        // achievement.true.rogue
        // achievement.classicist
        // achievement.true.warrior
        // achievement.conqueror
        // achievement.champion
        // achievement.true.wizard
        // achievement.fred.astair
        // achievement.bruce.lee
        // achievement.slay.a.red.dragon
        // achievement.worm.slayer
        // achievement.master.player

        return count($badges) === 23;
    }
}
