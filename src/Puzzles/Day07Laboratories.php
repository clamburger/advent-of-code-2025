<?php

namespace App\Puzzles;

use App\Day07\Manifold;
use App\Day07\QuantumManifold;

class Day07Laboratories extends AbstractPuzzle
{
    protected static int $day_number = 7;

    public function getPartOneAnswer(): int|string
    {
        $manifold = new Manifold($this->input);
        $manifold->fireBeam();

        return $manifold->splits;
    }

    public function getPartTwoAnswer(): int|string
    {
        $manifold = new QuantumManifold($this->input);
        $manifold->collapseTheSingularity();

        return $manifold->timelines;
    }
}
