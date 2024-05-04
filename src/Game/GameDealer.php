<?php

namespace App\Game;

use App\Output\ConsoleOutput;
use App\Player\PlayerInterface;

class GameDealer
{
    private Game $game;
    private ConsoleOutput $output;
    private PlayerInterface $black;
    private PlayerInterface $white;

    public function __construct(Game $game, ConsoleOutput $output, PlayerInterface $black, PlayerInterface $white)
    {
        $this->game = $game;
        $this->output = $output;
        $this->black = $black;
        $this->white = $white;
    }

    public function deal(): void
    {
        $game = $this->game;
        $output = $this->output;
        $black = $this->black;
        $white = $this->white;

        while (true) {
            $turn = $game->getTurn() === Color::BLACK ? '黒' : '白';
            $mark = $game->getTurn()->getMark();
            $output->write("$turn($mark) の手番です" . PHP_EOL);

            if (!$game->canPlay()) {
                $output->write('置ける場所がないのでパスします' . PHP_EOL);
                $game->pass();
                if ($game->finished()) {
                    break;
                }
                continue;
            }

            $output->write($game->currentBoard());

            try {
                if ($game->getTurn() === Color::BLACK) {
                    $black->play();
                } else {
                    $white->play();
                }
            } catch (\Exception $e) {
                $output->write(PHP_EOL . $e->getMessage() . PHP_EOL);
            }
            $output->write(PHP_EOL);
            if ($game->finished()) {
                break;
            }
        }

        $output->write('ゲーム終了' . PHP_EOL);
        $output->write($game->currentBoard());

        $result = $game->getResult();
        $output->write($result);
    }
}
