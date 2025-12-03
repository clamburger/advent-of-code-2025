<?php

namespace App\Day02;

use Illuminate\Support\Collection;

class Range
{
    private Collection $numbers;

    public function __construct(
        private readonly int $start,
        private readonly int $end
    ) {
        $this->numbers = collect(range($this->start, $this->end));
    }

    public static function fromString(string $raw): static
    {
        [$start, $end] = explode('-', $raw);
        return new static((int)$start, (int)$end);
    }

    public function isNumberInvalid(int $number): bool
    {
        $numberString = (string)$number;
        return preg_match('/^(.+)\\1$/', $numberString);
    }

    public function getInvalidNumbers(): Collection
    {
        return $this->numbers->filter($this->isNumberInvalid(...));
    }
}
