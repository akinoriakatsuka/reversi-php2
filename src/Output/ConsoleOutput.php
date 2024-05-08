<?php

namespace App\Output;

use App\GameDealer\OutputInterface;

class ConsoleOutput implements OutputInterface
{
    public function write(string $data): void
    {
        echo $data;
    }
}
