<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\HistoricalRetired;

final class HistoricalRetiredRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter( HistoricalRetired::query(), $criteria);
        $total = $query->count();

        $query->limit($criteria->limit)
            ->offset($criteria->offset);

        $results = $query->get();
        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }
}
