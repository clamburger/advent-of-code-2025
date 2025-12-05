<?php

namespace App\Puzzles;

use App\Day05\Cafeteria;
use App\Puzzles\AbstractPuzzle;

class Day05Cafeteria extends AbstractPuzzle
{
    protected static int $day_number = 5;

    public function getPartOneAnswer(): int|string
    {
        $cafeteria = new Cafeteria($this->input->lines_by_block);

        return $cafeteria->ingredients
            ->filter(fn ($ingredient) => $cafeteria->isIngredientFresh($ingredient))
            ->count();
    }

    public function getPartTwoAnswer(): int|string
    {
        $cafeteria = new Cafeteria($this->input->lines_by_block);
        $ranges = $cafeteria->combineRanges();

        $fresh = 0;

        foreach ($ranges as $range) {
            $fresh += $range['end'] - $range['start'] + 1;
        }

        return $fresh;
    }
}
