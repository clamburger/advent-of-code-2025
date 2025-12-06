<?php

namespace App\Day06;

use App\Input;
use Illuminate\Support\Collection;

class MathSheet
{
    private(set) Collection $problems;

    public function __construct(private readonly Input $input)
    {
        $this->parseProblemBlocks();
    }

    private function parseProblemBlocks(): void
    {
        $width = $this->input->lines->map(fn ($line) => $line->length())->max();
        $operatorStrings = $this->input->lines->last()->padRight($width, ' ')->matchAll('/[*+]\s*/');

        $problemWidths = $operatorStrings->map(fn ($string) => strlen($string) - 1);
        $problemWidths->put($problemWidths->count() - 1, $problemWidths->last() + 1);

        $this->problems = collect();

        $lineCount = $this->input->lines->count() - 1;

        $charactersConsumed = 0;

        foreach ($problemWidths as $index => $width) {
            $problem = [
                'operator' => trim($operatorStrings->get($index)),
                'numbers' => [],
            ];

            for ($i = 0; $i < $lineCount; $i++) {
                $problem['numbers'][] = $this->input->lines->get($i)->substr($charactersConsumed, $width);
            }

            $charactersConsumed += $width + 1;
            $this->problems->push($problem);
        }
    }

    public function solveProblem(array $problem)
    {
        $expression = implode($problem['operator'], $problem['numbers']);
        return eval("return " . $expression . ';');
    }
}
