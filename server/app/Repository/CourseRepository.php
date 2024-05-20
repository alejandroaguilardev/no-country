<?php

namespace App\Repository;

use App\Models\Course;

class CourseRepository
{

    public function getRecords(?int $limit = null, ?int $offset = null)
    {
        $limit = $limit ?? 10;
        $offset = $offset ?? 0;

        $query = Course::with('teachers', "students");
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
