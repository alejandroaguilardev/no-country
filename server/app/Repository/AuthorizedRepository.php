<?php

namespace App\Repository;

use App\Domain\Criteria\Criteria;
use App\Eloquent\EloquentQuery;
use App\Models\Authorized;

final class AuthorizedRepository
{
    public function getRecords(Criteria $criteria)
    {
        $query = EloquentQuery::queryConverter( Authorized::with('students'), $criteria);
        $total = $query->count();

        $query->limit($criteria->limit)
            ->offset($criteria->offset);

        $results = $query->get();
        return [
            "rows" => $results->toArray(),
            "count" => $total,
        ];
    }

    public function updateRecord(array $data)
    {
        foreach ($data['student_id'] as $id){
            $authorized = Authorized::findOrFail($id);
            $authorized->update(['name'=>$data['name'], 'last_name'=>$data['last_name'], 'document_number'=>$data[ 'document_number'],
            'phone'=>$data['phone'],'photo'=>$data['photo'],'tutor_id'=>$data['tutor_id'],'student_id'=>$id]);
        }
        return true;
    }
}
