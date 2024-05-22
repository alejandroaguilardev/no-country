<?php

namespace App\Http\Controllers\Authorizeds;

use App\Domain\Criteria\Criteria;
use App\Domain\Criteria\Filters;
use App\Domain\Criteria\Orders;
use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Repository\AuthorizedRepository;

class SearchAuthorizedController extends Controller
{
    public function __construct(
        private readonly AuthorizedRepository $repository
    ) {}

    public function __invoke(CriteriaRequest $request)
    {
        $criteria = new Criteria(
            $request['limit'] ?? 10,
            $request['offset'] ?? 0,
            $request['globalFilter'] ?? '',
            new Filters($request['filters'] ?? []),
            new Orders($request['sorts'] ?? []),
        );
        $data = $this->repository->getRecords($request["limit"], $request["offset"]);
        return response()->json($data, 200);
    }
}
