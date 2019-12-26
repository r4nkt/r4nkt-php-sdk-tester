<?php

namespace App\Http\Controllers;

use R4nkt\PhpSdk\R4nkt;
use Illuminate\Http\Request;
use App\Tasks\Actions\ActionsTaskGroup;
use App\Tasks\Rewards\RewardsTaskGroup;

class TestController extends Controller
{
    protected $r4nkt;

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->prep();
        $this->testActions();
        $this->testRewards();
    }

    protected function prep()
    {
        $this->r4nkt = new R4nkt(env('R4NKT_API_TOKEN'), env('R4NKT_GAME_ID'));
    }

    protected function testActions()
    {
        (new ActionsTaskGroup($this->r4nkt))->run();
    }

    protected function testRewards()
    {
        (new RewardsTaskGroup($this->r4nkt))->run();
    }
}
