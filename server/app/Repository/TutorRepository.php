<?php

namespace App\Repository;

use App\Models\Tutor;

class TutorRepository
{

    public function getRecords(?int $limit = null, ?int $offset = null)
    {
        $limit = $limit ?? 10;
        $offset = $offset ?? 0;
        $query = Tutor::with('students', 'authorized');
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
