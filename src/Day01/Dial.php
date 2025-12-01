<?php

namespace App\Day01;

use Illuminate\Support\Collection;

class Dial
{
    public const int DIAL_SIZE = 100;
    private(set) int $position = 50;
    private(set) Collection $movements;

    public function __construct()
    {
        $this->movements = collect();
    }

    public function rotate(string $instruction): void
    {
        $direction = $instruction[0];
        $steps = substr($instruction, 1);

        if ($direction === 'L') {
            $passesOfZero = $this->rotateLeft($steps);
        } elseif ($direction === 'R') {
            $passesOfZero = $this->rotateRight($steps);
        } else {
            throw new \Exception("You've dun goofed");
        }

        if ($this->position === 100) {
            $this->position = 0;
        }

        $this->movements->push([$instruction, $this->position, $passesOfZero]);
    }

    public function rotateLeft(int $steps): int
    {
        $passedZero = 0;

        $this->position -= $steps;
        while ($this->position < 0) {
            $this->position += 100;
            $passedZero++;
        }

        return $passedZero;
    }

    public function rotateRight(int $steps): int
    {
        $passedZero = 0;

        $this->position += $steps;
        while ($this->position >= 100) {
            $this->position -= 100;
            $passedZero++;
        }

        return $passedZero;
    }
}
