<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Repository\StudentRepository;

class SearchStudentController extends Controller
{
    public function __construct(
        private readonly StudentRepository $repository
    ) {}

    public function __invoke(CriteriaRequest $request)
    {
        $data = $this->repository->getRecords($request["limit"], $request["offset"]);
        return response()->json($data, 200);
    }
}
