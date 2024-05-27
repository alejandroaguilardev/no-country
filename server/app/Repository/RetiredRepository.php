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
        $query->limit($criteria->limit)
            ->offset($criteria->offset);

        $results = $query->get();
        $total = $query->count();
        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }
}
