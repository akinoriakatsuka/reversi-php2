<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\GameDealer\GameDealer;
use App\Game\GameFactory;
use App\Player\HumanPlayer;
use App\Player\CPUPlayer;
use App\Output\ConsoleOutput;

$game = GameFactory::create();
$output = new ConsoleOutput();
$black = new HumanPlayer($game);
$white = new CPUPlayer($game);

if (isset($argv[1])) {
    if ($argv[1] === 'cpu') {
        $black = new CPUPlayer($game);
    } elseif($argv[1] === 'human') {
        $black = new HumanPlayer($game);
    }
}

if (isset($argv[2])) {
    if ($argv[2] === 'cpu') {
        $white = new CPUPlayer($game);
    } elseif($argv[2] === 'human') {
        $white = new HumanPlayer($game);
    }
}

$dealer = new GameDealer($game, $output, $black, $white);

$dealer->deal();
