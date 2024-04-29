<?php

namespace App\Game;

class Board
{
    public array $cell_list;

    public function __construct()
    {
        $this->cell_list = [];
        for ($i = 0; $i < 8; $i++) {
            $this->cell_list[] = [];
            for ($j = 0; $j < 8; $j++) {
                $this->cell_list[$i][$j] = null;
            }
        }
    }

    public function setStone(int $x, int $y, Stone $stone): void
    {
        $this->cell_list[$x][$y] = $stone;
    }
}
