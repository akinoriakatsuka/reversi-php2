<?php

namespace App\Output;

class ConsoleOutput
{
    public function write(string $data): void
    {
        echo $data;
    }
}
