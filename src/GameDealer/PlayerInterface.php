<?php

namespace App\GameDealer;

interface PlayerInterface
{
    public function chooseCell(): array|false;
}
