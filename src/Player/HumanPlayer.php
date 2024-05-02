<?php

namespace App\Player;

class HumanPlayer {

    /**
     * 入力された文字列を返す
     */
    public function input(): string
    {
        return trim(fgets(STDIN));
    }

    /**
     * ゲームを中断するかどうかを返す
     */
    public function shouldQuit(string $input): bool
    {
        return $input === 'q';
    }

    /**
     * 入力された文字列をプレイする座標に変換して返す
     */
    public function getCell(string $input): array
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