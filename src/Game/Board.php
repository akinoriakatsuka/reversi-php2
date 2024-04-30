<?php

namespace App\Game;

class Board
{
    /**
     * @var array<array<Stone|null>> $cell_list
     */
    public array $cell_list;
    public readonly int $rows;
    public readonly int $columns;

    public function __construct(int $rows = 8, int $columns = 8)
    {
        $this->rows = $rows;
        $this->columns = $columns;
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
