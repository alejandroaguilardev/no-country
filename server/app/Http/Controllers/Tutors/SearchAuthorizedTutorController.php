<?php

namespace App\Http\Controllers\Tutors;

use App\Domain\Errors\CatchException;
use App\Http\Controllers\Controller;
use App\Repository\UserRepository;

class SearchAuthorizedTutorController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ) {}

    public function __invoke()
    {
        try {
            $user = auth()->user();
            $data = $this->repository->getAuthorizedsRecord($user->id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            $e = new CatchException($th);
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
