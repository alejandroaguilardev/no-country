<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Student;

final class StudentRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter(new Student(), Student::with('course', 'tutor', 'authorized'), $criteria);

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
