<?php

namespace App\Eloquent;

use App\Domain\Criteria\Criteria;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EloquentQuery
{

    public static function queryConverter(Model $model, Builder $query, Criteria $criteria)
    {
        self::enSecure($model, $criteria);

        EloquentHelper::whereAny($query, $criteria->globalFields, $criteria->globalFilter);
        EloquentHelper::where($query, $criteria->filters);
        EloquentHelper::order($query, $criteria->orders);

        $query
            ->limit($criteria->limit)
            ->offset($criteria->offset);

        return $query;
    }

    private static function enSecure(Model $model, Criteria $criteria): void
    {
        EloquentHelper::validateField($model, $criteria->filters);
        EloquentHelper::validateGlobalsFields($model, $criteria->globalFields);
        EloquentHelper::validateOrders($model, $criteria->orders);
    }
}
