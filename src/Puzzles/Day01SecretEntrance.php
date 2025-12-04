<?php

namespace App\Puzzles;

use App\Day01\Dial;

class Day01SecretEntrance extends AbstractPuzzle
{
    protected static int $day_number = 1;

    public function getPartOneAnswer(): int|string
    {
        $dial = new Dial();

        $lines = $this->input->lines;
        foreach ($lines as $line) {
            $dial->rotate($line);
        }

        return $dial->movements->where(1, 0)->count();
    }

    public function getPartTwoAnswer(): int|string
    {
        $dial = new Dial();

        $lines = $this->input->lines;
        foreach ($lines as $line) {
            $dial->rotate($line);
        }

        return $dial->movements->pluck(2)->sum();
    }
}
