<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\Game;

$game = new Game();

while (true) {
    // ゲームの処理
    if ($game->finished())
    {
        break;
    }
}

echo 'ゲーム終了' . PHP_EOL;