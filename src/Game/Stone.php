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
}
