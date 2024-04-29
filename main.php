<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\Game;
use App\Game\Board;
use App\Game\Color;

$board = new Board();
$game = new Game($board);

while (true) {
    $turn = $game->getTurn() === Color::BLACK ? '黒' : '白';
    echo $turn . ' の手番です' . PHP_EOL;
    echo $game->currentBoard();
    // 入力を受け付ける
    echo '石を置く場所を入力してください（qで途中終了）: ';

    $input = trim(fgets(STDIN));

    if ($input === 'q') {
        break;
    }

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
    };

    $game->play($row, $col);
    echo PHP_EOL;
    // ゲームの処理
    if ($game->finished()) {
        break;
    }
}

echo 'ゲーム終了' . PHP_EOL;
