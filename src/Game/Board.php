<?php

namespace App\Game;

class Board
{
    public array $cell_list;

    public function __construct($rows = 8, $columns = 8)
    {
        $this->cell_list = [];
        for ($i = 0; $i < $rows; $i++) {
            $this->cell_list[] = [];
            for ($j = 0; $j < $columns; $j++) {
                $this->cell_list[$i][$j] = null;
            }
        }
    }

    public function setStone(int $x, int $y, Stone $stone): void
    {
        $this->cell_list[$x][$y] = $stone;
    }
}
