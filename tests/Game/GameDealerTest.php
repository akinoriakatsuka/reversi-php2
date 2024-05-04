<?php

declare(strict_types=1);

namespace Tests\Game;

use App\Game\GameDealer;
use App\Game\Game;
use App\Game\Board;
use App\Game\Stone;
use App\Game\Color;
use App\Output\ConsoleOutput;
use App\Player\PlayerInterface;
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

        $output_mock = $this->createMock(ConsoleOutput::class);
        $output_mock->expects($this->any())->method('write')->with($this->isType('string'));

        $black = $this->createStub(PlayerInterface::class);
        $black->method('chooseCell')->willReturn([1, 2]);
        $white = $this->createStub(PlayerInterface::class);
        $dealer = new GameDealer($game, $output_mock, $black, $white);
        $dealer->deal();
        $this->assertTrue($game->finished());
    }
}
