<?php

namespace App\Puzzles;

use App\Day04\Department;
use App\Puzzles\AbstractPuzzle;

class Day04PrintingDepartment extends AbstractPuzzle
{
    protected static int $day_number = 4;

    public function getPartOneAnswer(): int|string
    {
        $department = new Department($this->input->grid);

        $canAccess = 0;

        for ($y = 0; $y < $department->rows; $y++) {
            for ($x = 0; $x < $department->cols; $x++) {
                $content = $department->get($y, $x);
                if ($content === '@') {
                    if ($department->canRollBeAccessed($y, $x)) {
                        $canAccess++;
                    }
                }
            }
        }

        return $canAccess;
    }

    public function getPartTwoAnswer(): int|string
    {
        $department = new Department($this->input->grid);

        $rollsRemoved = 0;

        while (true) {
            $rollCount = $department->rollCount();
            $rolls = $department->rollPositions;

            foreach ($rolls as $roll) {
                if ($department->canRollBeAccessed($roll['y'], $roll['x'])) {
                    $department->removeRoll($roll['y'], $roll['x']);
//                    echo "Removed row {$roll['y']} col {$roll['x']}\n";
                    $rollsRemoved++;
                }
            }

            $newRollCount = $department->rollCount();
            if ($rollCount === $newRollCount) {
                break;
            }
        }

        return $rollsRemoved;
    }
}
