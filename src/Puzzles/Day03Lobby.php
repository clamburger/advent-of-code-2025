<?php

namespace App\Puzzles;

use App\Day03\BatteryBank;

class Day03Lobby extends AbstractPuzzle
{
    protected static int $day_number = 3;

    public function getPartOneAnswer(): int|string
    {
        $banks = $this->input->grid->mapInto(BatteryBank::class);

        return $banks->map(fn (BatteryBank $bank) => $bank->findBiggestJoltage(2))->sum();
    }

    public function getPartTwoAnswer(): int|string
    {
        $banks = $this->input->grid->mapInto(BatteryBank::class);

        return $banks->map(fn (BatteryBank $bank) => $bank->findBiggestJoltage(12))->sum();
    }
}
