<?php

namespace App\Puzzles;

use App\Day06\BetterMathSheet;
use App\Day06\MathSheet;

class Day06TrashCompactor extends AbstractPuzzle
{
    protected static int $day_number = 6;

    public function getPartOneAnswer(): int|string
    {
        $sheet = new MathSheet($this->input);
        $solutions = $sheet->problems->map(fn ($problem) => $sheet->solveProblem($problem));
        return $solutions->sum();
    }

    public function getPartTwoAnswer(): int|string
    {
        $sheet = new BetterMathSheet($this->input);
        $solutions = $sheet->problems->map(fn ($problem) => $sheet->solveProblem($problem));
        return $solutions->sum();
    }
}
