<?php

declare(strict_types=1);

namespace Tests\Game;

use App\Game\Stone;
use App\Game\Color;
use App\Game\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    public function testSetStone(): void
    {
        $board = new Board();
        $stone = new Stone(Color::BLACK);
        $board->setStone(0, 0, $stone);
        $this->assertSame($board->cell_list[0][0]->getColor(), Color::BLACK);
    }

    public function testSetStoneInDifferentPosition(): void
    {
        $board = new Board(1, 1);
        $stone = new Stone(Color::WHITE);
        $board->setStone(1, 1, $stone);
        $this->assertSame($board->cell_list[1][1]->getColor(), Color::WHITE);
    }

    public function testNumberOf(): void
    {
        $board = new Board();
        $black = new Stone(Color::BLACK);
        $white = new Stone(Color::WHITE);
        $board->setStone(0, 0, $black);
        $board->setStone(0, 1, $white);
        $board->setStone(0, 2, $white);
        $this->assertSame($board->numberOf($black), 1);
        $this->assertSame($board->numberOf($white), 2);
    }
}
