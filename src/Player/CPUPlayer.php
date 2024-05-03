<?php

namespace App\Player;

use App\Game\Game;

class CPUPlayer implements Player
{
    public function __construct(private Game $game)
    {
    }

    public function play(): void
    {
        $playable = $this->game->getPlayableCells();
        $random_key = array_rand($playable);
        $row = $playable[$random_key][0];
        $col = $playable[$random_key][1];
        $this->game->play($row, $col);
    }
}
