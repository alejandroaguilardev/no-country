<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Retired;

class RetiredRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter(new Retired(), Retired::with('student'), $criteria);

        $results = $query->get();
        $total = Retired::count();
        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }
}
