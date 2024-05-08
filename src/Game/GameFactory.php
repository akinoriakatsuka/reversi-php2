<?php

namespace App\Game;

class GameFactory
{
    public static function create(): Game
    {
        $board = new Board();
        $board->setStone(3, 3, new Stone(Color::WHITE));
        $board->setStone(3, 4, new Stone(Color::BLACK));
        $board->setStone(4, 3, new Stone(Color::BLACK));
        $board->setStone(4, 4, new Stone(Color::WHITE));
        $game = new Game($board);
        return $game;
    }
}
