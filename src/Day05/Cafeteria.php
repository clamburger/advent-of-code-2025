<?php

namespace App\Day05;

use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;

class Cafeteria
{
    private(set) Collection $ranges;
    private(set) Collection $ingredients;

    public function __construct(Collection $blocks)
    {
        $this->ranges = $blocks->first()
            ->map(fn ($range) => $this->parseRange($range))
            ->sortBy([
                ['start', 'asc'],
                ['end', 'asc'],
            ]);
        $this->ingredients = $blocks->last()->map(fn (Stringable $ingredient) => $ingredient->toInteger());
    }

    private function parseRange(string $rangeString): array
    {
        [$start, $end]  = explode('-', $rangeString);

        return [
            'start' => (int) $start,
            'end' => (int) $end,
        ];
    }

    public function isIngredientFresh(int $ingredient): bool
    {
        foreach ($this->ranges as $range) {
            if ($ingredient >= $range['start'] && $ingredient <= $range['end']) {
                return true;
            }
        }

        return false;
    }

    public function combineRanges(): Collection
    {
        $lastRange = null;

        $newRanges = collect();

        foreach ($this->ranges as $range) {
            if ($lastRange === null) {
                $lastRange = $range;
                $added = false;
                continue;
            }

            if ($range['start'] <= $lastRange['end']) {
                $lastRange['end'] = max($lastRange['end'], $range['end']);
                $added = false;
                continue;
            }

            // If we've gotten here, there is no overlap with the last range.
            // Mark the last range as 'complete' and set this as the next one.
            $newRanges->push($lastRange);

            $lastRange = $range;
            $added = true;
        }

        $newRanges->push($lastRange);

        return $newRanges;
    }
}
