<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\Game;
use App\Game\Board;

$board = new Board();
$game = new Game($board);

while (true) {
    // ゲームの処理
    echo '現在の盤面' . PHP_EOL;
    echo $game->currentBoard();

    if ($game->finished())
    {
        break;
    }
}

echo 'ゲーム終了' . PHP_EOL;