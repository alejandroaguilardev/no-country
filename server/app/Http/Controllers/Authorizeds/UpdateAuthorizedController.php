<?php

namespace App\Http\Controllers\Authorizeds;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorized\UpdateAuthorizedRequest;
use App\Repository\AuthorizedRepository;


class UpdateAuthorizedController extends Controller
{
    public function __construct(
        private readonly AuthorizedRepository $repository
    ) {}

    public function __invoke(UpdateAuthorizedRequest $request)
    {
        $data = $request->validated();
        $this->repository->updateRecord($data);

        return response()->json([
            'message' => 'Autorizado guardado correctamente'
        ], 200);
    } 
}
