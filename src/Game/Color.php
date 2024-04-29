<?php

namespace App\Game;

enum Color
{
    case BLACK;
    case WHITE;

    public function getMark(): string
    {
        return match ($this) {
            self::BLACK => 'o',
            self::WHITE => 'x',
        };
    }
}
