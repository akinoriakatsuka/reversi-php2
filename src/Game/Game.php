<?php

namespace App\Game;

class Game
{
    private Board $board;
    private Color $turn;
    private int $pass_count;

    public function __construct(Board $board)
    {
        $this->board = $board;
        $this->turn = Color::BLACK;
        $this->pass_count = 0;
    }

    public function finished(): bool
    {
        if ($this->board->isFull()) {
            return true;
        }
        if ($this->pass_count >= 2) {
            return true;
        }
        return false;
    }

    public function pass(): void
    {
        $this->toggleTurn();
        $this->pass_count++;
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

    public function canPlay(): bool
    {
        $board = $this->board;
        for ($x = 0; $x < $board->rows; $x++) {
            for ($y = 0; $y < $board->columns; $y++) {
                if ($this->canPut($x, $y)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * 置けるマスを配列で返す
     * @return array<array<int>> [[x, y], [x, y], ...]
     */
    public function getPlayableCells(): array
    {
        $playable_cells = [];
        $board = $this->board;
        for ($x = 0; $x < $board->rows; $x++) {
            for ($y = 0; $y < $board->columns; $y++) {
                if ($this->canPut($x, $y)) {
                    $playable_cells[] = [$x, $y];
                }
            }
        }
        return $playable_cells;
    }

    /**
     * @throws \Exception
     */
    public function process(int $x, int $y): void
    {
        if(!$this->canPut($x, $y)) {
            throw new \Exception('ここには置けません');
        }

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
        $this->pass_count = 0;
        $this->toggleTurn();
    }

    public function canPut(int $x, int $y): bool
    {
        $board = $this->board;
        if ($x < 0 || $x >= $board->rows || $y < 0 || $y >= $board->columns) {
            return false;
        }
        if ($board->cell_list[$x][$y] !== null) {
            return false;
        }
        for ($dx = -1; $dx <= 1; $dx++) {
            for ($dy = -1; $dy <= 1; $dy++) {
                if ($dx === 0 && $dy === 0) {
                    continue;
                }
                if(!empty($this->getFlippableStones($x, $y, $dx, $dy))) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @return array<array<int>>
     */
    private function getFlippableStones(int $x, int $y, int $dx, int $dy): array
    {
        $turn = $this->turn;
        $board = $this->board;
        $opponent = ($turn === Color::BLACK) ? Color::WHITE : Color::BLACK;
        $flippable = [];
        while(true) {
            $x += $dx;
            $y += $dy;
            if($x < 0 || $x >= $board->rows || $y < 0 || $y >= $board->columns) {
                return [];
            }
            $cell = $this->board->cell_list[$x][$y];
            if($cell === null) {
                return [];
            }
            if($cell->getColor() === $turn) {
                break;
            }
            if($cell->getColor() === $opponent) {
                $flippable[] = [$x, $y];
            }
        }
        return $flippable;
    }

    private function flipStones(int $x, int $y, int $dx, int $dy): void
    {
        $flippable = $this->getFlippableStones($x, $y, $dx, $dy);
        foreach($flippable as $pos) {
            $this->board->cell_list[$pos[0]][$pos[1]]->flip();
        }
    }

    private function toggleTurn(): void
    {
        $this->turn = $this->turn === Color::BLACK ? Color::WHITE : Color::BLACK;
    }

    public function getResult(): string
    {
        $result = $this->getBoard()->numberOf(Color::BLACK) . '対' . $this->getBoard()->numberOf(Color::WHITE) . 'で ';
        if ($this->getWinner() === null) {
            $result .= '引き分けです' . PHP_EOL;
        } else {
            $winner = $this->getWinner() === Color::BLACK ? '黒' : '白';
            $result .= "$winner の勝ちです" . PHP_EOL;
        }
        return $result;
    }

    public function getWinner(): ?Color
    {
        $black_count = $this->board->numberOf(Color::BLACK);
        $white_count = $this->board->numberOf(Color::WHITE);
        if($black_count > $white_count) {
            return Color::BLACK;
        }
        if($black_count < $white_count) {
            return Color::WHITE;
        }
        return null;
    }
}
