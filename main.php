<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Game\Game;
use App\Game\Board;
use App\Game\Color;
use App\Game\Stone;

$board = new Board();
$board->setStone(3, 3, new Stone(Color::WHITE));
$board->setStone(3, 4, new Stone(Color::BLACK));
$board->setStone(4, 3, new Stone(Color::BLACK));
$board->setStone(4, 4, new Stone(Color::WHITE));
$game = new Game($board);

while (true) {

    $turn = $game->getTurn() === Color::BLACK ? '黒' : '白';
    $mark = $game->getTurn()->getMark();
    echo "$turn($mark) の手番です" . PHP_EOL;
    
    if (!$game->canPlay()) {
        echo '置ける場所がないのでパスします' . PHP_EOL;
        $game->pass();
        if ($game->finished()) {
            break;
        }
        continue;
    }
    
    echo $game->currentBoard();
    echo '石を置く場所を入力してください（qで途中終了）: ';

    $input = trim(fgets(STDIN));

    if ($input === 'q') {
        break;
    }

    $row = (int) $input[0] - 1;
    // TODO: 文字と座標のマッピングを後で改善する
    $col = match ($input[1]) {
        'a' => 0,
        'b' => 1,
        'c' => 2,
        'd' => 3,
        'e' => 4,
        'f' => 5,
        'g' => 6,
        'h' => 7,
        default => -1,
    };

    if ($col === -1 || $row < 0 || $row >= $game->getBoard()->rows || $col < 0 || $col >= $game->getBoard()->columns) {
        echo '置く場所の形式が間違っています' . PHP_EOL;
        continue;
    }

    try {
        $game->play($row, $col);
    } catch (Exception $e) {
        echo PHP_EOL . $e->getMessage() . PHP_EOL;
    }
    echo PHP_EOL;
    if ($game->finished()) {
        break;
    }
}

echo 'ゲーム終了' . PHP_EOL;
echo $game->currentBoard();
echo $game->getBoard()->numberOf(new Stone(Color::BLACK)) . '対' . $game->getBoard()->numberOf(new Stone(Color::WHITE)) . 'で ';
if ($game->getWinner() === null) {
    echo '引き分けです' . PHP_EOL;
} else {
    $winner = $game->getWinner() === Color::BLACK ? '黒' : '白';
    echo "$winner の勝ちです" . PHP_EOL;
}
