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

    public function getBoard(): Board
    {
        return $this->board;
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

        for ($dx = -1; $dx <= 1; $dx++) {
            for ($dy = -1; $dy <= 1; $dy++) {
                if ($dx === 0 && $dy === 0) {
                    continue;
                }
                $this->flipStones($x, $y, $dx, $dy);
            }
        }

        $this->toggleTurn();
    }

    public function canPut(int $x, int $y): bool
    {
        return false;
    }

    private function flipStones(int $x, int $y, int $dx, int $dy): void
    {
        $turn = $this->turn;
        $board = $this->board;
        $opponent = ($turn === Color::BLACK) ? Color::WHITE : Color::BLACK;
        $flippable = [];
        while(true) {
            $x += $dx;
            $y += $dy;
            if($x < 0 || $x >= $board->rows || $y < 0 || $y >= $board->columns) {
                return; // flipせずに終了
            }
            $cell = $this->board->cell_list[$x][$y];
            if($cell === null) {
                return; // flipせずに終了
            }
            if($cell->getColor() === $turn) {
                break;
            }
            if($cell->getColor() === $opponent) {
                $flippable[] = [$x, $y];
            }
        }
        foreach($flippable as $pos) {
            $this->board->cell_list[$pos[0]][$pos[1]]->flip();
        }
    }

    private function toggleTurn(): void
    {
        $this->turn = $this->turn === Color::BLACK ? Color::WHITE : Color::BLACK;
    }
}
