<?php

namespace App\Domain\Criteria;

use App\Http\Requests\CriteriaRequest;

class RequestToCriteria
{
    public static function converter(CriteriaRequest $data)
    {
        return new Criteria(
            $data['limit'] ?? 10,
            $data['offset'] ?? 0,
            $data['globalFilter'] ?? '',
            new Filters($data['filters'] ?? []),
            new Orders($data['sorts'] ?? []),
        );
    }
}
