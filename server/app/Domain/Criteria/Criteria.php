<?php

namespace App\Domain\Criteria;

class Criteria
{
    public function __construct(
        public readonly int $limit,
        public readonly int $offset,
        public readonly Filters $filters,
        public readonly Orders $orders,
        public readonly GlobalFields $globalFields,
        public readonly string $globalFilter,
    ) {}

    public function toArray()
    {
        return [
            "limit" => $this->limit,
            "offset" => $this->offset,
            "filters" => $this->filters->filters,
            "orders" => $this->orders->orders,
            "globalFields" => $this->globalFields->fields,
            "globalFilter" => $this->globalFilter,
        ];
    }
}
