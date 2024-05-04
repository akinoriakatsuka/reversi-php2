<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\GameFactory;
use App\Game\GameDealer;
use App\Player\HumanPlayer;
use App\Player\CPUPlayer;
use App\Output\ConsoleOutput;

$game = GameFactory::create();
$output = new ConsoleOutput();
$black = new HumanPlayer($game);
$white = new CPUPlayer($game);

$dealer = new GameDealer($game, $output, $black, $white);

$dealer->deal();
