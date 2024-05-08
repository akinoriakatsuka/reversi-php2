<?php

namespace App\Game;

use App\Game\Color;

class Stone
{
    private Color $color;

    public function __construct(Color $color)
    {
        $this->color = $color;
    }

    public function getColor(): Color
    {
        return $this->color;
    }

    public function flip(): void
    {
        $this->color = match ($this->color) {
            Color::BLACK => Color::WHITE,
            Color::WHITE => Color::BLACK,
        };
    }
}
