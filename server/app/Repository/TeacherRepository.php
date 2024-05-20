<?php

namespace App\Repository;

use App\Models\Teacher;

class TeacherRepository
{

    public function getRecords(?int $limit = null, ?int $offset = null)
    {
        $limit = $limit ?? 10;
        $offset = $offset ?? 0;

        $query = Teacher::with('course');
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
