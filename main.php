<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\GameFactory;
use App\Game\Color;
use App\Player\HumanPlayer;
use App\Player\CPUPlayer;
use App\Output\ConsoleOutput;

$game = GameFactory::create();

$black = new HumanPlayer($game);
$white = new CPUPlayer($game);

$output = new ConsoleOutput();

while (true) {
    $turn = $game->getTurn() === Color::BLACK ? '黒' : '白';
    $mark = $game->getTurn()->getMark();
    $output->write("$turn($mark) の手番です" . PHP_EOL);

    if (!$game->canPlay()) {
        $output->write('置ける場所がないのでパスします' . PHP_EOL);
        $game->pass();
        if ($game->finished()) {
            break;
        }
        continue;
    }

    $output->write($game->currentBoard());

    try {
        if ($game->getTurn() === Color::BLACK) {
            $black->play();
        } else {
            $white->play();
        }
    } catch (Exception $e) {
        $output->write(PHP_EOL . $e->getMessage() . PHP_EOL);
    }
    $output->write(PHP_EOL);
    if ($game->finished()) {
        break;
    }
}

$output->write('ゲーム終了' . PHP_EOL);
$output->write($game->currentBoard());

$result = $game->getResult();
$output->write($result);
