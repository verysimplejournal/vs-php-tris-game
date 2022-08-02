<?php

class Tris {
    public const POSITIONS = [
        0 => [0,1,2],
        1 => [0,1,2],
        2 => [0,1,2]
    ];
    public const WINNING_COMBINATIONS = [
        [[0,0],[0,1],[0,2]],
        [[1,0],[1,1],[1,2]],
        [[2,0],[2,1],[2,2]],
        [[0,0],[1,0],[2,0]],
        [[0,1],[1,1],[2,1]],
        [[0,2],[1,2],[2,2]],
        [[0,0],[1,1],[2,2]],
        [[0,2],[1,1],[2,0]]
    ];
    public const PLAYER_X = 'X';
    public const PLAYER_O = 'O';

    public static function hasPlayerWon(array $board, string $player): bool
    {
        foreach (self::WINNING_COMBINATIONS as $combo) {
            $hasWon = 0;
            foreach ($combo as $pos) {
                if ($board[$pos[0]][$pos[1]]==$player) {
                    $hasWon++;
                }
            }
            if ($hasWon == 3) {
                return true;
            }
        }

        return false;

    }

    public static function isEndGame(array $board): bool
    {
        $hasEnded = false;
        foreach ($board as $lines) {
            if (!in_array('',$lines)) {
                $hasEnded = true;
            } else {
                $hasEnded = false;
            }
        }
        return $hasEnded;
    }
}
