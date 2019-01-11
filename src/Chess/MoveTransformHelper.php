<?php declare(strict_types=1);

namespace App\Chess;

class MoveTransformHelper
{
    public static function moveArrayToString(?array $moves): string
    {
        if (empty($moves)) {
            return '';
        }

        $movesString = '';
        $moveCounter = 1;

        foreach ($moves as $key => $move) {
            if (0 === $key % 2) {
                $movesString = $movesString.$moveCounter.'.';
                $moveCounter++;
            }

            $movesString = $movesString.$move.' ';
        }

        return trim($movesString);
    }

    public static function moveStringToArray(string $moves): array
    {
        // Maybe it's better to build a dummy pgn, and throw it through chess.php...
        $movesArray = explode(' ', $moves);

        return array_map(
            function ($move) {
                if (preg_match('/^(\d+\.)?(.*)/', $move, $matches)) {
                    return $matches[2];
                }

                return $move;
            },
            $movesArray
        );
    }
}
