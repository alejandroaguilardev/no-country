<?php

namespace App\Http\Controllers\Authorizeds;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorized\LeaveAloneAuthorizedRequest;
use App\Repository\RetiredRepository;
use Illuminate\Http\Request;

class LeaveAloneAuthorizedController extends Controller
{
    public function __construct(
        private readonly RetiredRepository $repository
    ) {}

    public function __invoke(LeaveAloneAuthorizedRequest $request)
    {
        $data = $request->validated();
        $this->repository->updateLeaveAlone($data);

        return response()->json([
            'message' => 'Preferencia de retiro guardada correctamente'
        ], 200);
    } 
}
