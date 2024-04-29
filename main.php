<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\Game;

$game = new Game();

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