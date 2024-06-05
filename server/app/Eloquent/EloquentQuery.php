<?php

namespace App\Eloquent;

use App\Domain\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;

class EloquentQuery
{

    public static function queryConverter(Builder $query, Criteria $criteria)
    {
        EloquentHelper::whereAny($query, $criteria->globalFields, $criteria->globalFilter);
        EloquentHelper::where($query, $criteria->filters);
        EloquentHelper::order($query, $criteria->orders);

        return $query;
    }
}
