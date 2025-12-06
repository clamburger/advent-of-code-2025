<?php

namespace App\Day06;

class BetterMathSheet extends MathSheet
{
    public function solveProblem(array $problem)
    {
        $problem['numbers'] = $this->transposeNumbers($problem['numbers']);
        return parent::solveProblem($problem);
    }

    private function transposeNumbers(array $numbers): array
    {
        $w = $numbers[0]->length();
        $h = count($numbers);

        $newNumbers = [];
        for ($i = 0; $i <= $w; $i++) {
            $newNumber = '';
            for ($j = 0; $j <= $h; $j++) {
                $newNumber .= ($numbers[$j][$i] ?? ' ');
            }
            if (trim($newNumber) !== '') {
                $newNumbers[] = $newNumber;
            }
        }

        return $newNumbers;
    }
}
