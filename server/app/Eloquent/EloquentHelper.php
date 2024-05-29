<?php

namespace App\Eloquent;

use App\Domain\Criteria\Filters;
use App\Domain\Criteria\GlobalFields;
use App\Domain\Criteria\Orders;
use Illuminate\Database\Eloquent\Builder;

final class EloquentHelper
{
    public static function where(Builder $query, Filters $value)
    {
        foreach ($value->filters as $filter) {
            $condition = is_numeric($filter["value"]) ? ["=", ""] : ["LIKE", "%"];

            if (stripos($filter["field"], '.')) {
                [$relation, $field] = explode('.', $filter["field"]);
                $query->whereHas($relation, function ($relationQuery) use ($field, $filter, $condition) {
                    $relationQuery->where($field, $condition[0], $filter["value"] . $condition[1]);
                });
            } else {
                $query->where($filter["field"], $condition[0], $filter["value"] . $condition[1]);
            }
        }
    }

    public static function order(Builder $query, Orders $value)
    {
        foreach ($value->orders as $order) {
            $query->orderBy($order["orderBy"], $order["orderType"]);
        }
        return $query;
    }

    public static function whereAny(Builder $query, GlobalFields $globalFields, string $globalFilter)
    {
        if (!empty($globalFields->fields)) {
            $query->whereAny($globalFields->fields, 'LIKE', '%' . $globalFilter . '%');
        }
        return $query;
    }
}
