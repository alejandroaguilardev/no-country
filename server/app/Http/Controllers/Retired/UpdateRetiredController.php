<?php

namespace App\Http\Controllers\Retired;

use App\Http\Controllers\Controller;
use App\Http\Requests\Retired\RetiredRequest;
use App\Http\Requests\Retired\AusentRequest;
use App\Repository\RetiredRepository;


class UpdateRetiredController extends Controller
{
    private readonly RetiredRepository $repository;

    public function __construct(RetiredRepository $repository)
    {
        $this->repository = $repository;
    }

    public function markAsRetired( RetiredRequest $request)
    {
        $data = $request->validated();
        $this->repository->updateStatus($data);
        $data['presence']=true;

        return response()->json([
            'message' => $data
        ], 200);
    }
    

    public function markAsAbsent(AusentRequest $request)
    {
        $data = $request->validated();
        $this->repository->updatePresence($data);
        $data['status']=false;

        return response()->json([
            'message' => $data
        ], 200);
    }
}
