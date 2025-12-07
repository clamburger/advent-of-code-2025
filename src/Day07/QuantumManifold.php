<?php

namespace App\Day07;

use App\Input;
use Exception;
use Illuminate\Support\Collection;

class QuantumManifold
{
    private(set) int $timelines = 0;
    private(set) Collection $grid;
    private(set) Collection $splittersByRow;
    private(set) array $splitterPossiblities = [];

    public function __construct(Input $input)
    {
        $this->grid = $input->grid;

        $this->splittersByRow = $this->grid
            ->filter(fn(Collection $row) => $row->contains('^'))
            ->map(fn(Collection $row) => $row->filter(fn($char) => $char === '^'))
            ->map(fn(Collection $row) => $row->keys());
    }

    public function collapseTheSingularity(): void
    {
        $startCol = $this->grid->first()->search('S');
        $startRow = 2;

        $this->timelines = $this->getPossibilitiesForSplitter($startRow, $startCol);
    }

    private function getPossibilitiesForSplitter(int $row, int $col)
    {
        if ($this->grid->get($row)->get($col) !== '^') {
            throw new Exception("Row $row, col $col is not a splitter");
        }

        if (isset($this->splitterPossiblities[$row][$col])) {
            return $this->splitterPossiblities[$row][$col];
        }

        $nextSplitters = $this->getNextSplitters($row, $col);

        $possibilities = 2 - count($nextSplitters);

        foreach ($nextSplitters as $splitter) {
            $possibilities += $this->getPossibilitiesForSplitter($splitter['row'], $splitter['col']);
        }

        return $this->splitterPossiblities[$row][$col] = $possibilities;
    }

    private function getNextSplitters(int $row, int $col): array
    {
        $leftSplitter = $rightSplitter = null;
        $leftCol = $col - 1;
        $rightCol = $col + 1;

        for ($r = $row + 1; $r < $this->grid->count(); $r++) {
            if (!$leftSplitter && $this->grid->get($r)->get($leftCol) === '^') {
                $leftSplitter = ['row' => $r, 'col' => $leftCol];
            }
            if (!$rightSplitter && $this->grid->get($r)->get($rightCol) === '^') {
                $rightSplitter = ['row' => $r, 'col' => $rightCol];
            }
            if ($leftSplitter && $rightSplitter) {
                break;
            }
        }

        return array_filter([
            $leftSplitter,
            $rightSplitter,
        ]);
    }
}
