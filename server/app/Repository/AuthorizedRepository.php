<?php

namespace App\Repository;

use App\Models\Authorized;

class AuthorizedRepository
{

    public function getRecords(?int $limit = null, ?int $offset = null)
    {
        $limit = $limit ?? 10;
        $offset = $offset ?? 0;

        $query = Authorized::with('students');
        $results = $query->limit($limit)
            ->offset($offset)
            ->get();

        $total = Authorized::count();

        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }

    public function updateRecord(int $id,array $data)
    {
        $authorized = Authorized::findOrFail($id);

        $authorized->update($data);

        return $authorized;

    }
}
