<?php

namespace App\Domain\Criteria;

final class Filters
{
    public $filters = [];

    public function __construct(
        $filters,
    ) {
        $this->filters = $this->format($filters);
    }

    private function format($filters)
    {
        foreach ($filters as $filter) {
            $this->filters[] = [
                "field" => $filter["field"],
                "operator" => $filter["operator"],
                "value" => $filter["value"],
            ];
        }
    }

}
