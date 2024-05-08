<?php

declare(strict_types=1);

namespace Tests;

use App\Game\Game;
use App\Game\Board;
use App\Game\Color;
use App\Game\Stone;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public function testFinished(): void
    {
        $board = new Board();
        $game = new Game($board);
        $finished = $game->finished();
        $this->assertSame($finished, false);
    }

    public function testCurrentBoard(): void
    {
        $board = new Board(1, 8);
        $board->setStone(0, 0, new Stone(Color::WHITE));
        $board->setStone(0, 1, new Stone(Color::BLACK));
        $game = new Game($board);
        $currentBoard = $game->currentBoard();
        $expected = <<<EOL
          a b c d e f g h
        1 x o - - - - - -

        EOL;
        $this->assertSame($currentBoard, $expected);
    }

    public function testGetTurn(): void
    {
        $board = new Board();
        $game = new Game($board);
        $turn = $game->getTurn();
        $this->assertSame($turn, Color::BLACK);
    }

    public function testProcess(): void
    {
        $board = new Board(1, 8);
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 1, new Stone(Color::WHITE));
        $game = new Game($board);

        $game->process(0, 2);
        $this->assertSame($board->cell_list[0][1]?->getColor(), Color::BLACK);
    }

    public function testProcess2(): void
    {
        $board = new Board(1, 8);
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 1, new Stone(Color::WHITE));
        $board->setStone(0, 2, new Stone(Color::WHITE));
        $game = new Game($board);

        $game->process(0, 3);
        $this->assertSame($board->cell_list[0][1]?->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[0][2]?->getColor(), Color::BLACK);
    }
}
