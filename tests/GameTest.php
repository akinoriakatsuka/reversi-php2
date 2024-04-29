<?php

declare(strict_types=1);

namespace Tests;

use App\Game\Game;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public function testFinished(): void
    {
        $game = new Game();
        $finished = $game->finished();
        $this->assertSame($finished, true);
    }

    public function testCurrentBoard(): void
    {
        $game = new Game();
        $currentBoard = $game->currentBoard();
        $expected = <<<EOL
          a b c d e f g h
        1 - - - - - - - -
        2 - - - - - - - -
        3 - - - - - - - -
        4 - - - - - - - -
        5 - - - - - - - -
        6 - - - - - - - -
        7 - - - - - - - -
        8 - - - - - - - -

        EOL;
        $this->assertSame($currentBoard, $expected);
    }
}