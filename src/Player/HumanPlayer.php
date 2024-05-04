<?php

namespace App\Player;

use App\Game\Game;
use App\GameDealer\PlayerInterface;

class HumanPlayer implements PlayerInterface
{
    public function __construct(private Game $game)
    {
    }

    public function chooseCell(): array|false
    {
        $input = $this->input();
        if($input === 'q') {
            return false;
        }
        return $this->getCell($input);
    }

    /**
     * 入力された文字列を返す
     */
    private function input(): string
    {
        return trim(fgets(STDIN));
    }

    /**
     * 入力された文字列をプレイする座標に変換して返す
     */
    private function getCell(string $input): array
    {
        $row = (int) $input[0] - 1;
        $col = match ($input[1]) {
            'a' => 0,
            'b' => 1,
            'c' => 2,
            'd' => 3,
            'e' => 4,
            'f' => 5,
            'g' => 6,
            'h' => 7,
            default => -1,
        };

        return [$row, $col];
    }
}
