<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Retired;
use Carbon\Carbon;

class RetiredRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter(new Retired(), Retired::with('student.course', 'student.tutor', 'student.authorized'), $criteria);
        $total = $query->count();

        $query->limit($criteria->limit)
            ->offset($criteria->offset);
        $results = $query->get();

        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }

    public function updateStatus(array $data)
    {
        $retired = Retired::where('student_id', $data['student_id'])->firstOrFail();

        // Actualiza el estado, presencia y fecha
        $retired->update([
            'status' => $data['status'],
            'presence' => true,
            'date' => Carbon::now(),
        ]);

        return $retired;
    }

    public function updatePresence(array $data)
    {
        $retired = Retired::where('student_id', $data['student_id'])->firstOrFail();

        // Actualiza el estado, presencia y fecha
        $retired->update([
            'status' => false,
            'presence' => $data['presence'],
            'date' => Carbon::now(),
        ]);

        return $retired;
    }

    public function updateLeaveAlone(array $data)
    {
        foreach ($data['student_id'] as $id){
            $retired = Retired::findOrFail($id);
            $retired->update([
                'leave_alone'=>$data['leave_alone'],
                'student_id'=>$id
            ]);
        }
        return true;
    }
}
