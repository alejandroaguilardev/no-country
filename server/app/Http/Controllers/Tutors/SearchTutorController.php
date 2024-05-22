<?php

namespace App\Http\Controllers\Tutors;

use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Repository\TutorRepository;

class SearchTutorController extends Controller
{
    public function __construct(
        private readonly TutorRepository $repository
    ) {}

    public function __invoke(CriteriaRequest $request)
    {
        $data = $this->repository->getRecords($request["limit"], $request["offset"]);
        return response()->json($data, 200);
    }
}
