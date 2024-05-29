<?php

namespace App\Eloquent;

use App\Domain\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentQuery
{

    public static function queryConverter(Model $model, Builder $query, Criteria $criteria)
    {
        EloquentHelper::whereAny($query, $criteria->globalFields, $criteria->globalFilter);
        EloquentHelper::where($query, $criteria->filters);
        EloquentHelper::order($query, $criteria->orders);

        return $query;
    }
}
