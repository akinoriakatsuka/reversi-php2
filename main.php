<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\Game;
use App\Game\Board;
use App\Game\Color;
use App\Game\Stone;
use App\Player\HumanPlayer;
use App\Player\CPUPlayer;

$board = new Board();
$board->setStone(3, 3, new Stone(Color::WHITE));
$board->setStone(3, 4, new Stone(Color::BLACK));
$board->setStone(4, 3, new Stone(Color::BLACK));
$board->setStone(4, 4, new Stone(Color::WHITE));
$game = new Game($board);

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
echo $game->getBoard()->numberOf(new Stone(Color::BLACK)) . '対' . $game->getBoard()->numberOf(new Stone(Color::WHITE)) . 'で ';
if ($game->getWinner() === null) {
    echo '引き分けです' . PHP_EOL;
} else {
    $winner = $game->getWinner() === Color::BLACK ? '黒' : '白';
    echo "$winner の勝ちです" . PHP_EOL;
}
