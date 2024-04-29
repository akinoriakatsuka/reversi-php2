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

    public function play(int $x, int $y): void
    {
        $stone = new Stone($this->turn);
        $this->board->setStone($x, $y, $stone);

        if($x === 0 && $y === 2){
            $this->flipStones($x, $y, -1, 0);
        }

        $this->toggleTurn();
    }

    private function flipStones(int $x, int $y, int $dx, int $dy): void
    {
        $this->board->cell_list[0][1]->flip();
    }

    private function toggleTurn(): void
    {
        $this->turn = $this->turn === Color::BLACK ? Color::WHITE : Color::BLACK;
    }
}
