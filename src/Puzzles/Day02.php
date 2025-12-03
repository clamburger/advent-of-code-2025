<?php

namespace App\Puzzles;

use App\Day02\Range;
use App\Day02\StrictRange;
use Illuminate\Support\Collection;

class Day02 extends AbstractPuzzle
{
    protected static int $day_number = 2;

    public function getPartOneAnswer(): int|string
    {
        $ranges = $this->createRanges(Range::class);

        return $ranges
            ->map(fn ($range) => $range->getInvalidNumbers())
            ->flatten()
            ->sum();
    }

    public function getPartTwoAnswer(): int|string
    {
        $ranges = $this->createRanges(StrictRange::class);

        return $ranges
            ->map(fn ($range) => $range->getInvalidNumbers())
            ->flatten()
            ->sum();
    }

    /**
     * @template T of Range
     *
     * @param class-string<T> $rangeClass
     *
     * @return Collection<array-key, T>
     */
    private function createRanges(string $rangeClass): Collection
    {
        return $this->input->raw->split('/,/')
            ->map(fn ($rangeString) => $rangeClass::fromString($rangeString));
    }
}
