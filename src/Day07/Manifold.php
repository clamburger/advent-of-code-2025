<?php

namespace App\Day07;

use App\Input;
use Illuminate\Support\Collection;

class Manifold
{
    private(set) int $splits = 0;
    private(set) Collection $grid;

    public function __construct(Input $input)
    {
        $this->grid = $input->grid;
    }

    public function fireBeam(): void
    {
        $startCol = $this->grid->first()->search('S');
        $height = $this->grid->count();

        $beams = [
            $startCol,
        ];

        for ($rowNum = 1; $rowNum < $height; $rowNum++) {
            $newBeams = [];
            $row = $this->grid->get($rowNum);
            foreach ($beams as $beamCol) {
                $char = $row->get($beamCol);
                if ($char === '.') {
                    $newBeams[] = $beamCol;
                } elseif ($char === '^') {
                    $newBeams[] = $beamCol - 1;
                    $newBeams[] = $beamCol + 1;
                    $this->splits++;
                }
            }

            $beams = array_unique($newBeams);
        }
    }
}
