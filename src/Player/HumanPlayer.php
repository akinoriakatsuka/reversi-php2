<?php

namespace App\Player;
use App\Game\Game;

class HumanPlayer implements Player
{

    public function __construct(private Game $game)
    {
    }

    public function play(): void
    {
        echo '石を置く場所を入力してください（qで途中終了）: ';
        $input = $this->input();
        if ($this->shouldQuit($input)) {
            exit;
        }
        $cell = $this->getCell($input);
        $row = $cell[0];
        $col = $cell[1];
        $this->game->process($row, $col);
    }

    /**
     * 入力された文字列を返す
     */
    private function input(): string
    {
        return trim(fgets(STDIN));
    }

    /**
     * ゲームを中断するかどうかを返す
     */
    private function shouldQuit(string $input): bool
    {
        return $input === 'q';
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