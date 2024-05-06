<?php

namespace App\GameDealer;

interface PlayerInterface
{
    /**
     * @return array<int>|false
    */
    public function chooseCell(): array|false;
}
