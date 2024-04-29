<?php

namespace App\Game;

class Game
{
    private Board $board;

    public function __construct($board)
    {
        $this->board = $board;
    }

    public function finished(): bool
    {
        return true;
    }

    public function currentBoard(): string
    {
        $cell_list = $this->board->cell_list;
        $output = '  a b c d e f g h' . PHP_EOL;
        foreach ($cell_list as $row_index => $row) {
            $output .= $row_index + 1;
            foreach ($row as $cell) {
                $output .= ' -';
            }
            $output .= PHP_EOL;
        }
        return $output;
    }
}
