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
        $authorized = $this->repository->updateRecord($data['tutor_id'], $data);

        return response()->json([
            'message' => 'Autorizado guardado correctamente',
            'autorizado' => $authorized
        ], 200);
    } 
}
