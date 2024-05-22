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
}
