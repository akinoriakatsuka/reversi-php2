<?php

declare(strict_types=1);

namespace Tests;

use App\Game\Stone;
use App\Game\Color;
use PHPUnit\Framework\TestCase;

final class StoneTest extends TestCase
{
    public function testGetColor(): void
    {
        $stone = new Stone(Color::BLACK);
        $this->assertSame($stone->getColor(), Color::BLACK);
    }

    public function testFlip(): void
    {
        $stone = new Stone(Color::BLACK);
        $stone->flip();
        $this->assertSame($stone->getColor(), Color::WHITE);
    }
}
