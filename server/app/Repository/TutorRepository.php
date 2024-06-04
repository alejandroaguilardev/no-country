<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Tutor;

class TutorRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter(Tutor::with('students', 'authorizeds'), $criteria);
        $total = $query->count();

        $query->limit($criteria->limit)
            ->offset($criteria->offset);
        $results = $query->get();

        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }

    public function getStudentsRecord(int $id)
    {
        $tutor = Tutor::with('students' )->where('id', $id)->first();
        return $tutor->students;
    }

    public function getAuthorizedsRecord(int $id)
    {
        $tutor = Tutor::with('authorizeds' )->where('id', $id)->first();
        return $tutor->authorizeds;
    }
}
