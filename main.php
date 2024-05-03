<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\GameFactory;
use App\Game\Color;
use App\Player\HumanPlayer;
use App\Player\CPUPlayer;

$game = GameFactory::create();

$black = new HumanPlayer($game);
$white = new CPUPlayer($game);

while (true) {
    $turn = $game->getTurn() === Color::BLACK ? '黒' : '白';
    $mark = $game->getTurn()->getMark();
    echo "$turn($mark) の手番です" . PHP_EOL;

    if (!$game->canPlay()) {
        echo '置ける場所がないのでパスします' . PHP_EOL;
        $game->pass();
        if ($game->finished()) {
            break;
        }
        continue;
    }

    echo $game->currentBoard();

    try {
        if ($game->getTurn() === Color::BLACK) {
            $black->play();
        } else {
            $white->play();
        }
    } catch (Exception $e) {
        echo PHP_EOL . $e->getMessage() . PHP_EOL;
    }
    echo PHP_EOL;
    if ($game->finished()) {
        break;
    }
}

echo 'ゲーム終了' . PHP_EOL;
echo $game->currentBoard();
echo $game->getBoard()->numberOf(Color::BLACK) . '対' . $game->getBoard()->numberOf(Color::WHITE) . 'で ';
if ($game->getWinner() === null) {
    echo '引き分けです' . PHP_EOL;
} else {
    $winner = $game->getWinner() === Color::BLACK ? '黒' : '白';
    echo "$winner の勝ちです" . PHP_EOL;
}
