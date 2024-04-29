<?php

declare(strict_types=1);

namespace Tests;

use App\Game\Board;
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
}