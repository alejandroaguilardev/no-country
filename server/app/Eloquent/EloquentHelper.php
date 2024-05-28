<?php

namespace App\Eloquent;

use App\Domain\Criteria\Filters;
use App\Domain\Criteria\GlobalFields;
use App\Domain\Criteria\Orders;
use App\Domain\Errors\ErrorDomain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

final class EloquentHelper
{

    public static function validateField(Model $model, Filters $value)
    {
        $fillableFields = $model->getFillable();

        foreach ($value->filters as $filter) {
            $fieldExists = in_array($filter["field"], $fillableFields);
            if (!$fieldExists) {
                throw new ErrorDomain('El campo ' . $filter["field"] . ' en los filtros no existe en el modelo Authorized', 400);
            }
        }
    }

    public static function where(Builder $query, Filters $value)
    {
        foreach ($value->filters as $filter) {
            if (stripos($filter["field"], 'id') && $filter["field"] === "id") {
                $query->where($filter["field"], "=", $filter["value"]);
            } else {
                $query->where($filter["field"], "LIKE", $filter["value"] . '%');
            }
        }
        return $query;
    }

    public static function validateOrders(Model $model, Orders $value)
    {
        $fillableFields = $model->getFillable();

        foreach ($value->orders as $order) {
            $fieldExists = in_array($order["orderBy"], $fillableFields);
            if (!$fieldExists) {
                throw new ErrorDomain('El campo ' . $order["orderBy"] . ' en los filtros no existe en el modelo Authorized', 400);
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

    public static function validateGlobalsFields(Model $model, GlobalFields $value)
    {
        $fillableFields = $model->getFillable();

        foreach ($value->fields as $field) {
            $fieldExists = in_array($field, $fillableFields);
            if (!$fieldExists) {
                throw new ErrorDomain('El campo ' . $field . ' en los GlobalFields no existe en el modelo Authorized', 400);
            }
        }
    }

    public static function whereAny(Builder $query, GlobalFields $globalFields, string $globalFilter)
    {
        if (!empty($globalFields->fields)) {
            $query->whereAny($globalFields->fields, 'LIKE', '%' . $globalFilter . '%');
        }
        return $query;
    }
}
