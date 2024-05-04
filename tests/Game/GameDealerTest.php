<?php

declare(strict_types=1);

namespace Tests\Game;

use App\Player\CPUPlayer;
use App\Game\GameFactory;
use App\Game\GameDealer;
use App\Output\ConsoleOutput;
use PHPUnit\Framework\TestCase;

class GameDealerTest extends TestCase
{
    /**
     * GameDealerのdealメソッドが終了するときにゲームが終了していることを確認する
     */
    public function testDeal(): void
    {
        $game = GameFactory::create();
        $output_mock = $this->createMock(ConsoleOutput::class);
        $output_mock->expects($this->any())->method('write')->with($this->isType('string'));

        $black = new CPUPlayer($game);
        $white = new CPUPlayer($game);
        $dealer = new GameDealer($game, $output_mock, $black, $white);
        $dealer->deal();
        $this->assertTrue($game->finished());
    }
}