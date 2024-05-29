<?php

namespace App\Domain\Criteria;

final class Filters
{
    public array $filters = [];

    public function __construct(array $filters = [])
    {
        $this->filters = [];
        $this->format($filters);
    }

    private function format(array $filters): void
    {
        foreach ($filters as $filter) {
            $this->filters[] = [
                "field" => $filter["field"],
                "value" => $filter["value"],
            ];
        }
    }

    public function toArray(): array
    {
        return $this->filters;
    }

}
