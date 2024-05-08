<?php

namespace App\Game;

enum Color: string
{
    case BLACK = 'black';
    case WHITE = 'white';

    public function getMark(): string
    {
        return match ($this) {
            self::BLACK => 'o',
            self::WHITE => 'x',
        };
    }
}
