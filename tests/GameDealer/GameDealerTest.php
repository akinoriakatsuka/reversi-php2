<?php

declare(strict_types=1);

namespace Tests\GameDealer;

use App\GameDealer\GameDealer;
use App\GameDealer\PlayerInterface;
use App\GameDealer\OutputInterface;
use App\Game\Game;
use App\Game\Board;
use App\Game\Stone;
use App\Game\Color;
use PHPUnit\Framework\TestCase;

class GameDealerTest extends TestCase
{
    /**
     * GameDealerのdealメソッドが終了するときにゲームが終了していることを確認する
     */
    public function testDeal(): void
    {
        $board = new Board(1, 3);
        $board->setStone(1, 0, new Stone(Color::BLACK));
        $board->setStone(1, 1, new Stone(Color::WHITE));
        $game = new Game($board);

        $output_mock = $this->createMock(OutputInterface::class);
        $output_mock->expects($this->any())->method('write')->with($this->isType('string'));

        $black = $this->createStub(PlayerInterface::class);
        $black->method('chooseCell')->willReturn([1, 2]);
        $white = $this->createStub(PlayerInterface::class);
        $dealer = new GameDealer($game, $output_mock, $black, $white);
        $dealer->deal();
        $this->assertTrue($game->finished());
    }
}
