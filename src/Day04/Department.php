<?php

namespace App\Day04;

use Illuminate\Support\Collection;

class Department
{
    private(set) int $rows;
    private(set) int $cols;
    private(set) array $rollPositions;

    public function __construct(private readonly Collection $grid)
    {
        $this->rows = $grid->count();
        $this->cols = $grid->first()->count();

        $this->rollPositions = [];
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $col) {
                if ($col === '@') {
                    $this->rollPositions['r' . $y . ', c' . $x] = ['x' => $x, 'y' => $y];
                }
            }
        }
    }

    public function canRollBeAccessed(int $y, int $x): bool
    {
        return $this->getAdjacentPaperCount($y, $x) < 4;
    }

    public function removeRoll(int $y, int $x): void
    {
        $row = $this->grid->get($y);
        $row->put($x, '.');
        $this->grid->put($y, $row);

        unset($this->rollPositions['r' . $y . ', c' . $x]);
    }

    public function showMap(): void
    {
        foreach ($this->grid as $row) {
            foreach ($row as $col) {
                echo $col;
            }
            echo "\n";
        }
    }

    public function getAdjacentPaperCount(int $y, int $x): int
    {
        $positions = [
            [$y - 1, $x - 1],
            [$y - 1, $x    ],
            [$y - 1, $x + 1],
            [$y    , $x - 1],

            [$y    , $x + 1],
            [$y + 1, $x - 1],
            [$y + 1, $x    ],
            [$y + 1, $x + 1],
        ];

        $rolls = 0;

        foreach ($positions as $position) {
            $content = $this->get($position[0], $position[1]);
            if ($content === '@') {
                $rolls++;
            }
        }

        return $rolls;
    }

    public function get(int $y, int $x): ?string
    {
        $row = $this->grid->get($y);
        if ($row === null) {
            return null;
        }

        return $row->get($x);
    }

    public function rollCount(): int
    {
        return count($this->rollPositions);
    }
}
