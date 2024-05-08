<?php

namespace App\GameDealer;

interface OutputInterface
{
    public function write(string $data): void;
}
