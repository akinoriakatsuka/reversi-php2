<?php

namespace App\Game;

class Game
{
    private Board $board;
    private Color $turn;

    public function __construct($board)
    {
        $this->board = $board;
        $this->turn = Color::BLACK;
    }

    public function finished(): bool
    {
        return false;
    }

    public function getTurn(): Color
    {
        return $this->turn;
    }

    public function currentBoard(): string
    {
        $cell_list = $this->board->cell_list;
        $output = '  a b c d e f g h' . PHP_EOL;
        foreach ($cell_list as $row_index => $row) {
            $output .= $row_index + 1;
            foreach ($row as $cell) {
                if ($cell === null) {
                    $output .= ' -';
                } else {
                    $output .= ' ' . $cell->getColor()->getMark();
                }
            }
            $output .= PHP_EOL;
        }
        return $output;
    }

    public function process(int $x, int $y): void
    {
        $stone = new Stone($this->turn);
        $this->board->setStone($x, $y, $stone);

        while (true) {
            $y -= 1;
            if ($y < 0) {
                $flip_cell_list = [];
                break;
            }
            $cell = $this->board->cell_list[$x][$y];
            if ($cell === null) {
                $flip_cell_list = [];
                break;
            }

            if ($cell->getColor() === $this->turn) {
                break;
            } else {
                $flip_cell_list[] = $cell;
            }
        }
        if(!empty($flip_cell_list)) {
            foreach ($flip_cell_list as $cell) {
                $cell?->flip();
            }
        }
        $this->toggleTurn();
    }

    private function toggleTurn(): void
    {
        $this->turn = $this->turn === Color::BLACK ? Color::WHITE : Color::BLACK;
    }
}
