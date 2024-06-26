<?php

namespace App\Player;

use App\Game\Game;
use App\GameDealer\PlayerInterface;

class CPUPlayer implements PlayerInterface
{
    public function __construct(private Game $game)
    {
    }

    /**
     * @return array<int>
     */
    public function chooseCell(): array
    {
        $playable = $this->game->getPlayableCells();
        $random_key = array_rand($playable);
        $row = $playable[$random_key][0];
        $col = $playable[$random_key][1];
        return [$row, $col];
    }
}
