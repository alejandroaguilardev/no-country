<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\CriteriaRequest;
use App\Repository\CourseRepository;

class SearchCourseController extends Controller
{
    public function __construct(
        private readonly CourseRepository $repository
    ) {}

    public function __invoke(CriteriaRequest $request)
    {
        $data = $this->repository->getRecords($request["limit"], $request["offset"]);
        return response()->json($data, 200);
    }
}
