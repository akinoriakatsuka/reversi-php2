<?php

namespace App\Game;

use App\Output\OutputInterface;
use App\Player\PlayerInterface;

class GameDealer
{
    public function __construct(
        private Game $game,
        private OutputInterface $output,
        private PlayerInterface $black,
        private PlayerInterface $white
    ) {
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
                    $cell = $black->chooseCell();
                    $this->game->process($cell[0], $cell[1]);
                } else {
                    $cell = $white->chooseCell();
                    $this->game->process($cell[0], $cell[1]);
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
