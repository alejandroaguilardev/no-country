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
        $query = EloquentQuery::queryConverter(new Retired(), Retired::with('student'), $criteria);

        $results = $query->get();
        $total = Retired::count();
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
            'date' => Carbon::now()
        ]);

        return $retired;
    }

    public function updatePresence(array $data)
    {
        $retired = Retired::where('student_id', $data['student_id'])->firstOrFail();

        // Actualiza el estado, presencia y fecha
        $retired->update([
            'status' =>false,
            'presence' => $data['presence'],
            'date' => Carbon::now()
        ]);

        return $retired;
    }
}

