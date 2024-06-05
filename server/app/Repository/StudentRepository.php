<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Student;

final class StudentRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter(Student::with('course', 'tutor', 'authorized', 'retired'), $criteria);
        $total = $query->count();

        $query->limit($criteria->limit)
            ->offset($criteria->offset);
        $results = $query->get();

        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }

    public function getCourseStudentsRecords( int $id)
    {
        $results = Student::with('course', 'tutor', 'authorized', 'retired')->where("course_id", "=", $id)->get();

        return $results->toArray();
    }
}
