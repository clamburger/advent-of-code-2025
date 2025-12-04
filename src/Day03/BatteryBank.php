<?php

namespace App\Day03;

use Illuminate\Support\Collection;

class BatteryBank
{
    private(set) Collection $batteries;

    public function __construct(Collection $line)
    {
        $this->batteries = $line->map(fn ($digit) => (int)$digit);
    }

    public function findBiggestJoltage(int $batteryCount): int
    {
        $bestDigits = array_fill(0, $batteryCount, null);

        $count = $this->batteries->count();

        for ($i = 0; $i < $count; $i++) {
            $value = $this->batteries[$i];

            for ($b = 0; $b < $batteryCount; $b++) {
                // Simple check: is this a better option than the current battery at that position?
                $betterOption = $bestDigits[$b] === null || $value > $bestDigits[$b];
                // Slightly more complicated check: if we use this battery, will there be enough
                // batteries left to fill the remaining count?
                $isThereSpace = $this->isThereSpace($i, $batteryCount - $b);

                if ($betterOption && $isThereSpace) {
                    $bestDigits[$b] = $value;
                    // Clear all batteries after the selected battery
                    foreach ($bestDigits as $digitIndex => $_) {
                        if ($digitIndex > $b) {
                            $bestDigits[$digitIndex] = null;
                        }
                    }

                    continue 2;
                }
            }
        }

        return $this->digitsToJoltage($bestDigits);
    }

    private function isThereSpace(int $currentIndex, int $batteriesRemaining): bool
    {
        return $batteriesRemaining + $currentIndex <= $this->batteries->count();
    }

    private function digitsToJoltage(array $digits): int
    {
        return array_reduce($digits, fn ($joltage, $digit) => $joltage . $digit);
    }
}
