<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Authorized;

final class AuthorizedRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter(new Authorized(), Authorized::with('students'), $criteria);

        $results = $query->get();
        $total = Authorized::count();
        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }
}
