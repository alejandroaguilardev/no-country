<?php

namespace App\Repository;

use App\Models\Retired;

class RetiredRepository
{

    public function getRecords(?int $limit = null, ?int $offset = null)
    {
        $limit = $limit ?? 10;
        $offset = $offset ?? 0;

        $query = Retired::with('student');
        $results = $query->limit($limit)
            ->offset($offset)
            ->get();

        $total = $query->count();

        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }
}
