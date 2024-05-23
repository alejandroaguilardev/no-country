<?php

namespace App\Domain\Criteria;

class Criteria
{
    public function __construct(
        public readonly int $limit,
        public readonly int $offset,
        public readonly string $globalFilter,
        public readonly Filters $filters,
        public readonly Orders $orders,
    ) {}

    public function toArray()
    {
        return [
            "limit" => $this->limit,
            "offset" => $this->offset,
            "globalFilter" => $this->globalFilter,
            "filters" => $this->filters->filters,
            "orders" => $this->orders->orders,
        ];
    }
}
