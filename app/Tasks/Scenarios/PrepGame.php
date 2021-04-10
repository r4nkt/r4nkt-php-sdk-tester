<?php

namespace App\Tasks\Scenarios;

use App\Tasks\AbstractTask;
use Exception;
use Illuminate\Support\Arr;
use R4nkt\PhpSdk\QueryParams\AchievementsParams;
use R4nkt\PhpSdk\R4nkt;

class PrepGame extends AbstractTask
{
    protected $count;

    protected function runTask()
    {
        $this->buildActions();
        $this->buildCriteria();
        $this->buildCriteriaGroups();
        $this->buildRewards();
        $this->buildAchievements();
        $this->buildLeaderboards();

        $params = (new AchievementsParams())->withSecrets();

        $this->count = $this->r4nkt->achievements($params)->total();
        $this->count += $this->r4nkt->actions()->total();
        $this->count += $this->r4nkt->criteria()->total();
        $this->count += $this->r4nkt->criteriaGroups()->total();
        $this->count += $this->r4nkt->leaderboards()->total();
        $this->count += $this->r4nkt->players()->total();
        $this->count += $this->r4nkt->rewards()->total();
    }

    protected function taskPassed(): bool
    {
        try {
            $this->checkBasics();

            /** @todo Move all these resource-focused checks into actual tests. */
            $this->checkAchievements();
            $this->checkActions();
        } catch (Exception $e) {
            dump($e->getMessage());

            return false;
        }

        return true;
    }

    protected function checkBasics()
    {
        $expectedCount = 31 // achievements
            + 25 // achievement auto-created criteria groups
            + 35 // actions
            + 38 // criteria
            + 12 // criteria groups
            + 1 // leaderboards
            + 0 // players
            + 24 // rewards
        ;

        if ($this->count != $expectedCount) {
            throw new Exception("Unexpected resource count: {$this->count}");
        }
    }

    protected function checkAchievements()
    {
        $achievement = $this->r4nkt->achievement('achievement.master.player');

        if ($achievement->custom_criteria_group_id !== 'criteria.group.master.player') {
            throw new Exception('Specified custom criteria group not found on achievement');
        }
    }

    protected function checkActions()
    {
        $action = $this->r4nkt->action('action.slay.a.red.dragon');
        $reactionsA = $action->reactions();

        $reactionsB = $this->r4nkt->actionReactions('action.slay.a.red.dragon');

        if (count($reactionsA) !== count($reactionsB)) {
            throw new Exception('Reactions count mismatch between access methods');
        }

        for ($x=0; $x < count($reactionsA); $x++) {
            if ($reactionsA[$x]->custom_id !== $reactionsB[$x]->custom_id) {
                throw new Exception('Custom reaction IDs do not match');
            }
        }
    }

    protected function buildActions()
    {
        $actions = [
            [
                'custom_id' => 'action.slay.an.enemy',
                'name' => 'action.slay.an.enemy',
            ],
            [
                'custom_id' => 'action.slay.champion',
                'name' => 'action.slay.champion',
                'reactions' => [
                    'action.slay.an.enemy',
                ],
            ],
            [
                'custom_id' => 'action.slay.a.dragon',
                'name' => 'action.slay.a.dragon',
                'reactions' => [
                    'action.slay.an.enemy',
                ],
            ],
            [
                'custom_id' => 'action.slay.a.red.dragon',
                'name' => 'action.slay.a.red.dragon',
                'reactions' => [
                    'action.slay.a.dragon',
                    'action.slay.champion',
                ],
            ],
            [
                'custom_id' => 'action.slay.hydra',
                'name' => 'action.slay.hydra',
                'reactions' => [
                    'action.slay.an.enemy',
                ],
            ],
            [
                'custom_id' => 'action.heal.self',
                'name' => 'action.heal.self',
            ],
            [
                'custom_id' => 'action.heal.another',
                'name' => 'action.heal.another',
            ],
            [
                'custom_id' => 'action.detect.trap',
                'name' => 'action.detect.trap',
            ],
            [
                'custom_id' => 'action.disarm.trap',
                'name' => 'action.disarm.trap',
            ],
            [
                'custom_id' => 'action.complete.quest',
                'name' => 'action.complete.quest',
            ],
            [
                'custom_id' => 'action.break.breakable',
                'name' => 'action.break.breakable',
            ],
            [
                'custom_id' => 'action.smash.door',
                'name' => 'action.smash.door',
                'reactions' => [
                    'action.break.breakable',
                ],
            ],
            [
                'custom_id' => 'action.solve.puzzle',
                'name' => 'action.solve.puzzle',
            ],
            [
                'custom_id' => 'action.solve.water.chamber.puzzle',
                'name' => 'action.solve.water.chamber.puzzle',
                'reactions' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.solve.lava.field.puzzle',
                'name' => 'action.solve.lava.field.puzzle',
                'reactions' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.solve.clockworks.puzzle',
                'name' => 'action.solve.clockworks.puzzle',
                'reactions' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.solve.five.doors.puzzle',
                'name' => 'action.solve.five.doors.puzzle',
                'reactions' => [
                    'action.solve.puzzle',
                ],
            ],
            [
                'custom_id' => 'action.deal.critical.strike',
                'name' => 'action.deal.critical.strike',
            ],
            [
                'custom_id' => 'action.play.as.wizard',
                'name' => 'action.play.as.wizard',
            ],
            [
                'custom_id' => 'action.play.as.cleric',
                'name' => 'action.play.as.cleric',
            ],
            [
                'custom_id' => 'action.play.as.rogue',
                'name' => 'action.play.as.rogue',
            ],
            [
                'custom_id' => 'action.play.as.warrior',
                'name' => 'action.play.as.warrior',
            ],
            [
                'custom_id' => 'action.play.as.human',
                'name' => 'action.play.as.human',
            ],
            [
                'custom_id' => 'action.play.as.elf',
                'name' => 'action.play.as.elf',
            ],
            [
                'custom_id' => 'action.play.as.dwarf',
                'name' => 'action.play.as.dwarf',
            ],
            [
                'custom_id' => 'action.play.as.halfling',
                'name' => 'action.play.as.halfling',
            ],
            [
                'custom_id' => 'action.die',
                'name' => 'action.die',
            ],
            [
                'custom_id' => 'action.find.secret.room',
                'name' => 'action.find.secret.room',
            ],
            [
                'custom_id' => 'action.open.chest',
                'name' => 'action.open.chest',
            ],
            [
                'custom_id' => 'action.dodge.attack',
                'name' => 'action.dodge.attack',
            ],
            [
                'custom_id' => 'action.dodge.melee.attack',
                'name' => 'action.dodge.melee.attack',
                'reactions' => [
                    'action.dodge.attack',
                ],
            ],
            [
                'custom_id' => 'action.dodge.missile.attack',
                'name' => 'action.dodge.missile.attack',
                'reactions' => [
                    'action.dodge.attack',
                ],
            ],
            [
                'custom_id' => 'action.sell.item',
                'name' => 'action.sell.item',
            ],
            [
                'custom_id' => 'action.use.potion',
                'name' => 'action.use.potion',
            ],
            [
                'custom_id' => 'action.defeat.ethereal.queen',
                'name' => 'action.defeat.ethereal.queen',
                'reactions' => [
                    'action.slay.champion',
                ],
            ],
        ];

        collect($actions)->each(function ($attributes) {
            $action = $this->r4nkt->createAction($attributes);
        });
    }

    protected function buildCriteria()
    {
        $criteria = [
            [
                'custom_id' => 'criterion.slay.a.red.dragon',
                'name' => 'criterion.slay.a.red.dragon',
                'custom_action_id' => 'action.slay.a.red.dragon',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.slay.10.dragons',
                'name' => 'criterion.slay.10.dragons',
                'custom_action_id' => 'action.slay.a.dragon',
                'type' => 'sum',
                'rule' => 'gte:10',
            ],
            [
                'custom_id' => 'criterion.slay.10.enemies',
                'name' => 'criterion.slay.10.enemies',
                'custom_action_id' => 'action.slay.an.enemy',
                'type' => 'sum',
                'rule' => 'gte:10',
            ],
            [
                'custom_id' => 'criterion.smash.5.doors',
                'name' => 'criterion.smash.5.doors',
                'custom_action_id' => 'action.smash.door',
                'type' => 'sum',
                'rule' => 'gte:5',
            ],
            [
                'custom_id' => 'criterion.heal.self.25.times',
                'name' => 'criterion.heal.self.25.times',
                'custom_action_id' => 'action.heal.self',
                'type' => 'sum',
                'rule' => 'gte:25',
            ],
            [
                'custom_id' => 'criterion.slay.hydra',
                'name' => 'criterion.slay.hydra',
                'custom_action_id' => 'action.slay.hydra',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.detect.trap',
                'name' => 'criterion.detect.trap',
                'custom_action_id' => 'action.detect.trap',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.detect.5.traps',
                'name' => 'criterion.detect.5.traps',
                'custom_action_id' => 'action.detect.trap',
                'type' => 'sum',
                'rule' => 'gte:5',
            ],
            [
                'custom_id' => 'criterion.disarm.trap',
                'name' => 'criterion.disarm.trap',
                'custom_action_id' => 'action.disarm.trap',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.disarm.5.traps',
                'name' => 'criterion.disarm.5.traps',
                'custom_action_id' => 'action.disarm.trap',
                'type' => 'sum',
                'rule' => 'gte:5',
            ],
            [
                'custom_id' => 'criterion.complete.quest',
                'name' => 'criterion.complete.quest',
                'custom_action_id' => 'action.complete.quest',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.break.100.breakables',
                'name' => 'criterion.break.100.breakables',
                'custom_action_id' => 'action.break.breakable',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.solve.puzzle',
                'name' => 'criterion.solve.puzzle',
                'custom_action_id' => 'action.solve.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.water.chamber.puzzle',
                'name' => 'criterion.solve.water.chamber.puzzle',
                'custom_action_id' => 'action.solve.water.chamber.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.lava.field.puzzle',
                'name' => 'criterion.solve.lava.field.puzzle',
                'custom_action_id' => 'action.solve.lava.field.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.clockworks.puzzle',
                'name' => 'criterion.solve.clockworks.puzzle',
                'custom_action_id' => 'action.solve.clockworks.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.solve.five.doors.puzzle',
                'name' => 'criterion.solve.five.doors.puzzle',
                'custom_action_id' => 'action.solve.five.doors.puzzle',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.deal.100.critical.strikes',
                'name' => 'criterion.deal.100.critical.strikes',
                'custom_action_id' => 'action.deal.critical.strike',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.play.as.cleric',
                'name' => 'criterion.play.as.cleric',
                'custom_action_id' => 'action.play.as.cleric',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.rogue',
                'name' => 'criterion.play.as.rogue',
                'custom_action_id' => 'action.play.as.rogue',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.warrior',
                'name' => 'criterion.play.as.warrior',
                'custom_action_id' => 'action.play.as.warrior',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.wizard',
                'name' => 'criterion.play.as.wizard',
                'custom_action_id' => 'action.play.as.wizard',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.dwarf',
                'name' => 'criterion.play.as.dwarf',
                'custom_action_id' => 'action.play.as.dwarf',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.elf',
                'name' => 'criterion.play.as.elf',
                'custom_action_id' => 'action.play.as.elf',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.halfling',
                'name' => 'criterion.play.as.halfling',
                'custom_action_id' => 'action.play.as.halfling',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.play.as.human',
                'name' => 'criterion.play.as.human',
                'custom_action_id' => 'action.play.as.human',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.die.once',
                'name' => 'criterion.die.once',
                'custom_action_id' => 'action.die',
                'type' => 'sum',
                'rule' => 'gte:1',
            ],
            [
                'custom_id' => 'criterion.die.10.times',
                'name' => 'criterion.die.10.times',
                'custom_action_id' => 'action.die',
                'type' => 'sum',
                'rule' => 'gte:10',
            ],
            [
                'custom_id' => 'criterion.slay.100.champions',
                'name' => 'criterion.slay.100.champions',
                'custom_action_id' => 'action.slay.champion',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.find.50.secret.rooms',
                'name' => 'criterion.find.50.secret.rooms',
                'custom_action_id' => 'action.find.secret.room',
                'type' => 'sum',
                'rule' => 'gte:50',
            ],
            [
                'custom_id' => 'criterion.open.100.chests',
                'name' => 'criterion.open.100.chests',
                'custom_action_id' => 'action.open.chest',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.dodge.500.attacks',
                'name' => 'criterion.dodge.500.attacks',
                'custom_action_id' => 'action.dodge.attack',
                'type' => 'sum',
                'rule' => 'gte:500',
            ],
            [
                'custom_id' => 'criterion.sell.100.items',
                'name' => 'criterion.sell.100.items',
                'custom_action_id' => 'action.sell.item',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.use.100.potions',
                'name' => 'criterion.use.100.potions',
                'custom_action_id' => 'action.use.potion',
                'type' => 'sum',
                'rule' => 'gte:100',
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.cleric',
                'name' => 'criterion.defeat.ethereal.queen.as.cleric',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,cleric',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.rogue',
                'name' => 'criterion.defeat.ethereal.queen.as.rogue',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,rogue',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.warrior',
                'name' => 'criterion.defeat.ethereal.queen.as.warrior',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,warrior',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'custom_id' => 'criterion.defeat.ethereal.queen.as.wizard',
                'name' => 'criterion.defeat.ethereal.queen.as.wizard',
                'custom_action_id' => 'action.defeat.ethereal.queen',
                'type' => 'sum',
                'rule' => 'gte:1',
                'conditions' => [
                    'groups' => [
                        [
                            'conditions' => [
                                'activityData:class,eq,wizard',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        collect($criteria)->each(function ($attributes) {
            try {
                $criterion = $this->r4nkt->createCriterion($attributes);
            } catch (Exception $e) {
                dump("Exception building criteria: {$e->getMessage()}");
                dump($criterion);
                exit;
            }
        });
    }

    protected function buildCriteriaGroups()
    {
        $criteriaGroups = [
            [
                'custom_id' => 'criteria.group.queen.slayer',
                'name' => 'criteria.group.queen.slayer',
                'operator' => 'and',
                'criteria' => [
                    'criterion.defeat.ethereal.queen.as.cleric',
                    'criterion.defeat.ethereal.queen.as.rogue',
                    'criterion.defeat.ethereal.queen.as.warrior',
                    'criterion.defeat.ethereal.queen.as.wizard',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.monster.slayer',
                'name' => 'criteria.group.monster.slayer',
                'operator' => 'and',
                'criteria' => [
                    'criterion.slay.100.champions',
                    'criterion.dodge.500.attacks',
                    'criterion.deal.100.critical.strikes',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.worm.slayer',
                'name' => 'criteria.group.worm.slayer',
                'operator' => 'and',
                'criteria' => [
                    'criterion.slay.a.red.dragon',
                    'criterion.slay.hydra',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.slayer.of.legends',
                'name' => 'criteria.group.slayer.of.legends',
                'operator' => 'and',
                'criteria' => [],
                'criteria_groups' => [
                    'criteria.group.queen.slayer',
                    'criteria.group.monster.slayer',
                    'criteria.group.worm.slayer',
                ],
            ],
            [
                'custom_id' => 'criteria.group.tomb.raider',
                'name' => 'criteria.group.tomb.raider',
                'operator' => 'and',
                'criteria' => [
                    'criterion.find.50.secret.rooms',
                    'criterion.open.100.chests',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.dungeon.destroyer',
                'name' => 'criteria.group.dungeon.destroyer',
                'operator' => 'and',
                'criteria' => [
                    'criterion.smash.5.doors',
                    'criterion.break.100.breakables',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.thief.extraordinaire',
                'name' => 'criteria.group.thief.extraordinaire',
                'operator' => 'and',
                'criteria' => [
                    'criterion.detect.5.traps',
                    'criterion.disarm.5.traps',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.solver.of.riddles',
                'name' => 'criteria.group.solver.of.riddles',
                'operator' => 'and',
                'criteria' => [
                    'criterion.solve.water.chamber.puzzle',
                    'criterion.solve.lava.field.puzzle',
                    'criterion.solve.clockworks.puzzle',
                    'criterion.solve.five.doors.puzzle',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.display.of.excellence',
                'name' => 'criteria.group.display.of.excellence',
                'operator' => 'or',
                'criteria' => [],
                'criteria_groups' => [
                    'criteria.group.tomb.raider',
                    'criteria.group.dungeon.destroyer',
                    'criteria.group.thief.extraordinaire',
                    'criteria.group.solver.of.riddles',
                ],
            ],
            [
                'custom_id' => 'criteria.group.classy',
                'name' => 'criteria.group.classy',
                'operator' => 'and',
                'criteria' => [
                    'criterion.play.as.cleric',
                    'criterion.play.as.rogue',
                    'criterion.play.as.warrior',
                    'criterion.play.as.wizard',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.diversity',
                'name' => 'criteria.group.diversity',
                'operator' => 'and',
                'criteria' => [
                    'criterion.play.as.dwarf',
                    'criterion.play.as.elf',
                    'criterion.play.as.halfling',
                    'criterion.play.as.human',
                ],
                'criteria_groups' => [],
            ],
            [
                'custom_id' => 'criteria.group.master.player',
                'name' => 'criteria.group.master.player',
                'operator' => 'and',
                'criteria' => [
                    'criterion.complete.quest',
                ],
                'criteria_groups' => [
                    'criteria.group.display.of.excellence',
                    'criteria.group.slayer.of.legends',
                ],
            ],
        ];

        collect($criteriaGroups)->each(function ($attributes) {
            try {
                $criteriaGroup = $this->r4nkt->createCriteriaGroup($attributes);
            } catch (Exception $e) {
                dump("Exception building criteria groups: {$e->getMessage()}");
                dump($criteriaGroup);
                exit;
            }
        });
    }

    protected function buildRewards()
    {
        $rewards = [
            [
                'custom_id' => 'reward.10.gold.pieces',
                'name' => 'reward.10.gold.pieces',
            ],
            [
                'custom_id' => 'reward.100.gold.pieces',
                'name' => 'reward.100.gold.pieces',
            ],
            [
                'custom_id' => 'reward.1000.gold.pieces',
                'name' => 'reward.1000.gold.pieces',
            ],
            [
                'custom_id' => 'reward.10000.gold.pieces',
                'name' => 'reward.10000.gold.pieces',
            ],
            [
                'custom_id' => 'reward.uncommon.chest',
                'name' => 'reward.uncommon.chest',
            ],
            [
                'custom_id' => 'reward.rare.chest',
                'name' => 'reward.rare.chest',
            ],
            [
                'custom_id' => 'reward.epic.chest',
                'name' => 'reward.epic.chest',
            ],
            [
                'custom_id' => 'reward.legendary.chest',
                'name' => 'reward.legendary.chest',
            ],
            [
                'custom_id' => 'reward.mythic.chest',
                'name' => 'reward.mythic.chest',
            ],
            [
                'custom_id' => 'reward.random.uncommon.weapon',
                'name' => 'reward.random.uncommon.weapon',
            ],
            [
                'custom_id' => 'reward.random.rare.weapon',
                'name' => 'reward.random.rare.weapon',
            ],
            [
                'custom_id' => 'reward.random.epic.weapon',
                'name' => 'reward.random.epic.weapon',
            ],
            [
                'custom_id' => 'reward.random.legendary.weapon',
                'name' => 'reward.random.legendary.weapon',
            ],
            [
                'custom_id' => 'reward.random.mythic.weapon',
                'name' => 'reward.random.mythic.weapon',
            ],
            [
                'custom_id' => 'reward.random.uncommon.armor',
                'name' => 'reward.random.uncommon.armor',
            ],
            [
                'custom_id' => 'reward.random.rare.armor',
                'name' => 'reward.random.rare.armor',
            ],
            [
                'custom_id' => 'reward.random.epic.armor',
                'name' => 'reward.random.epic.armor',
            ],
            [
                'custom_id' => 'reward.random.legendary.armor',
                'name' => 'reward.random.legendary.armor',
            ],
            [
                'custom_id' => 'reward.random.mythic.armor',
                'name' => 'reward.random.mythic.armor',
            ],
            [
                'custom_id' => 'reward.random.uncommon.amulet',
                'name' => 'reward.random.uncommon.amulet',
            ],
            [
                'custom_id' => 'reward.random.rare.amulet',
                'name' => 'reward.random.rare.amulet',
            ],
            [
                'custom_id' => 'reward.random.epic.amulet',
                'name' => 'reward.random.epic.amulet',
            ],
            [
                'custom_id' => 'reward.random.legendary.amulet',
                'name' => 'reward.random.legendary.amulet',
            ],
            [
                'custom_id' => 'reward.random.mythic.amulet',
                'name' => 'reward.random.mythic.amulet',
            ],
        ];

        collect($rewards)->each(function ($attributes) {
            try {
                $reward = $this->r4nkt->createReward($attributes);
            } catch (Exception $e) {
                dump("Exception building rewards: {$e->getMessage()}");
                dump($reward);
                exit;
            }
        });
    }

    protected function buildAchievements()
    {
        $achievements = [
            [
                'custom_id' => 'achievement.slay.a.red.dragon',
                'name' => 'achievement.slay.a.red.dragon',
                'description' => 'achievement.description',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 100,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.slay.a.red.dragon',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.dragonslayer',
                'name' => 'achievement.dragonslayer',
                'description' => 'slay 10 dragons',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 100,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.slay.10.dragons',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.champion',
                'name' => 'achievement.champion',
                'description' => 'slay 10 enemies',
                'type' => 'standard',
                'is_secret' => true,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.slay.10.enemies',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.doorman',
                'name' => 'achievement.doorman',
                'description' => 'smash a door',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 5,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.smash.5.doors',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.self.helper',
                'name' => 'achievement.self.helper',
                'description' => 'heal self 25 times',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 25,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.heal.self.25.times',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.worm.slayer',
                'name' => 'achievement.worm.slayer',
                'description' => 'slay a dragon and a hydra',
                'type' => 'standard',
                'is_secret' => true,
                'points' => 250,
                'custom_criteria_group_id' => 'criteria.group.worm.slayer',
            ],
            [
                'custom_id' => 'achievement.caution',
                'name' => 'achievement.caution',
                'description' => 'detect a trap',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 10,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.detect.trap',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.extreme.caution',
                'name' => 'achievement.extreme.caution',
                'description' => 'detect 5 traps',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.detect.5.traps',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.smooth.operator',
                'name' => 'achievement.smooth.operator',
                'description' => 'disarm trap',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 10,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.disarm.trap',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.winner',
                'name' => 'achievement.winner',
                'description' => 'complete quest',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 1000,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.complete.quest',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.bull.in.china.shop',
                'name' => 'achievement.bull.in.china.shop',
                'description' => 'break 100 breakables',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.break.100.breakables',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.puzzler',
                'name' => 'achievement.puzzler',
                'description' => 'solve a puzzle',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 10,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.solve.puzzle',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.master.puzzler',
                'name' => 'achievement.master.puzzler',
                'description' => 'solve water chamber, lava field, clockworks, and five doors puzzles',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 250,
                'custom_criteria_group_id' => 'criteria.group.solver.of.riddles',
            ],
            [
                'custom_id' => 'achievement.bruce.lee',
                'name' => 'achievement.bruce.lee',
                'description' => 'deliver 100 critical strikes',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 25,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.deal.100.critical.strikes',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.classy',
                'name' => 'achievement.classy',
                'description' => 'play as each class',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'custom_criteria_group_id' => 'criteria.group.classy',
            ],
            [
                'custom_id' => 'achievement.diversity',
                'name' => 'achievement.diversity',
                'description' => 'play as each race',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'custom_criteria_group_id' => 'criteria.group.diversity',
            ],
            [
                'custom_id' => 'achievement.mortal',
                'name' => 'achievement.mortal',
                'description' => 'die',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 0,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.die.once',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.suicidal',
                'name' => 'achievement.suicidal',
                'description' => 'die 10 times',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 0,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.die.10.times',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.conqueror',
                'name' => 'achievement.conqueror',
                'description' => 'slay 100 champions',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 100,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.slay.100.champions',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.sherlock',
                'name' => 'achievement.sherlock',
                'description' => 'find 50 secret rooms',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 100,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.find.50.secret.rooms',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.jack.sparrow',
                'name' => 'achievement.jack.sparrow',
                'description' => 'open 100 chests',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 25,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.open.100.chests',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.fred.astair',
                'name' => 'achievement.fred.astair',
                'description' => 'dodge 500 attacks',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 150,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.dodge.500.attacks',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.pusher',
                'name' => 'achievement.pusher',
                'description' => 'sell 100 items',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 10,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.sell.100.items',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.addict',
                'name' => 'achievement.addict',
                'description' => 'consume 100 potions',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 10,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.use.100.potions',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.cleric',
                'name' => 'achievement.true.cleric',
                'description' => 'defeat the ethereal queen as a cleric',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.cleric',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.rogue',
                'name' => 'achievement.true.rogue',
                'description' => 'defeat the ethereal queen as a rogue',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.rogue',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.warrior',
                'name' => 'achievement.true.warrior',
                'description' => 'defeat the ethereal queen as a warrior',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.warrior',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.true.wizard',
                'name' => 'achievement.true.wizard',
                'description' => 'defeat the ethereal queen as a wizard',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 50,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.defeat.ethereal.queen.as.wizard',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.classicist',
                'name' => 'achievement.classicist',
                'description' => 'defeat the ethereal queen with each of the four classes',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 500,
                'custom_criteria_group_id' => 'criteria.group.queen.slayer',
            ],
            [
                'custom_id' => 'achievement.sir.traps.a.lot',
                'name' => 'achievement.sir.traps.a.lot',
                'description' => 'disarm five traps',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 15,
                'criteria_group' => [
                    'criteria' => [
                        'criterion.disarm.5.traps',
                    ],
                ],
            ],
            [
                'custom_id' => 'achievement.master.player',
                'name' => 'achievement.master.player',
                'description' => 'has shown a display of excellence and is known as a slayer of legends',
                'type' => 'standard',
                'is_secret' => false,
                'points' => 2500,
                'custom_criteria_group_id' => 'criteria.group.master.player',
            ],
        ];

        collect($achievements)->each(function ($attributes) {
            try {
                $achievement = $this->r4nkt->createAchievement($attributes);
            } catch (Exception $e) {
                dump("Exception building achievements: {$e->getMessage()}");
                dump($achievement ?? 'no achievement available');
                exit;
            }
        });
    }

    protected function buildLeaderboards()
    {
        $leaderboards = [
            [
                'custom_id' => 'leaderboard.default',
                'name' => 'leaderboard.default',
                'description' => 'leaderboard.description',
                'type' => 'standard',
            ],
        ];

        collect($leaderboards)->each(function ($attributes) {
            try {
                $leaderboard = $this->r4nkt->createLeaderboard($attributes);
            } catch (Exception $e) {
                dump("Exception building leaderboards: {$e->getMessage()}");
                dump($leaderboard ?? 'no leaderboard available');
                exit;
            }
        });
    }
}
