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

        $board = new Board(1, 1);
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $game = new Game($board);
        $finished = $game->finished();
        $this->assertSame($finished, true);
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

    public function testPlay(): void
    {
        $board = new Board(1, 8);
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 1, new Stone(Color::WHITE));
        $game = new Game($board);

        $game->play(0, 2);
        $this->assertSame($game->getTurn(), Color::WHITE);
        $currentBoard = $game->currentBoard();
        $expected = <<<EOL
          a b c d e f g h
        1 o o o - - - - -

        EOL;
        $this->assertSame($currentBoard, $expected);
    }

    /**
     * 複数の石をひっくり返す処理が正しく動いているか確認
     */
    public function testPlay2(): void
    {
        $board = new Board(1, 8);
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 1, new Stone(Color::WHITE));
        $board->setStone(0, 2, new Stone(Color::WHITE));
        $game = new Game($board);

        $game->play(0, 3);

        $board = $game->getBoard();

        $this->assertSame($board->cell_list[0][0]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[0][1]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[0][2]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[0][3]->getColor(), Color::BLACK);
    }

    /**
     * 複数の方向の石をひっくり返す処理が正しく動いているか確認
     */
    public function testPlay3(): void
    {
        $board = new Board(5, 5);
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 2, new Stone(Color::BLACK));
        $board->setStone(0, 4, new Stone(Color::BLACK));
        $board->setStone(2, 0, new Stone(Color::BLACK));
        $board->setStone(2, 4, new Stone(Color::BLACK));
        $board->setStone(4, 0, new Stone(Color::BLACK));
        $board->setStone(4, 2, new Stone(Color::BLACK));
        $board->setStone(4, 4, new Stone(Color::BLACK));
        $board->setStone(1, 1, new Stone(Color::WHITE));
        $board->setStone(1, 2, new Stone(Color::WHITE));
        $board->setStone(1, 3, new Stone(Color::WHITE));
        $board->setStone(2, 1, new Stone(Color::WHITE));
        $board->setStone(2, 3, new Stone(Color::WHITE));
        $board->setStone(3, 1, new Stone(Color::WHITE));
        $board->setStone(3, 2, new Stone(Color::WHITE));
        $board->setStone(3, 3, new Stone(Color::WHITE));

        $game = new Game($board);

        $game->play(2, 2);

        $board = $game->getBoard();

        $this->assertSame($board->cell_list[1][1]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[1][2]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[1][3]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[2][1]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[2][3]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[3][1]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[3][2]->getColor(), Color::BLACK);
        $this->assertSame($board->cell_list[3][3]->getColor(), Color::BLACK);
    }

    public function testCanPut(): void
    {
        $board = new Board();
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 1, new Stone(Color::WHITE));
        $game = new Game($board);
        // 枠の外は置けない
        $this->assertFalse($game->canPut(-1, 0));
        // すでに石がある時は置けない
        $this->assertFalse($game->canPut(0, 0));
        // 挟める石がない時は置けない
        $this->assertFalse($game->canPut(1, 1));
        // 挟める石がある時は置ける
        $this->assertTrue($game->canPut(0, 2));
    }

    public function testCanPlay(): void
    {
        $board = new Board();
        $board->setStone(0, 0, new Stone(Color::BLACK));
        $board->setStone(0, 1, new Stone(Color::WHITE));
        $game = new Game($board);
        $this->assertTrue($game->canPlay());

        $board = new Board();
        $board->setStone(0, 0, new Stone(Color::WHITE));
        $board->setStone(0, 1, new Stone(Color::BLACK));
        $game = new Game($board);
        $this->assertFalse($game->canPlay());
    }

    public function testPass(): void
    {
        $board = new Board();
        $game = new Game($board);
        $game->pass();
        $this->assertSame($game->getTurn(), Color::WHITE);
        $this->assertFalse($game->finished());
        $game->pass();
        $this->assertSame($game->getTurn(), Color::BLACK);
        $this->assertTrue($game->finished());
    }
}
