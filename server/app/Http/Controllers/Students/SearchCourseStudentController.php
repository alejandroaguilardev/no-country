<?php

namespace App\Http\Controllers\Students;

use App\Domain\Errors\CatchException;
use App\Domain\Errors\ErrorDomain;
use App\Http\Controllers\Controller;
use App\Repository\StudentRepository;

class SearchCourseStudentController extends Controller
{
    public function __construct(
        private readonly StudentRepository $repository
    ) {}

    public function __invoke( string $id)
    {
        try {
            $id = $this->validateIdentifier($id);
            $data = $this->repository->getCourseStudentsRecords($id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $e = new CatchException($th);
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    private function validateIdentifier(string $id) {
        if(!is_numeric($id)) {
            throw new ErrorDomain("No es un identificador válido", 400);
        }
        return $id;       
    }
}
