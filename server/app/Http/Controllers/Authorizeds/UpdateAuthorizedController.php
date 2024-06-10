<?php

namespace App\Http\Controllers\Authorizeds;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authorized\UpdateAuthorizedRequest;
use App\Repository\AuthorizedRepository;
use App\Services\Storage\ImageService;

class UpdateAuthorizedController extends Controller
{
    private $path = "public/images/";

    public function __construct(
        private readonly AuthorizedRepository $repository,
        private readonly ImageService $imageService
    ) {}

    public function __invoke(UpdateAuthorizedRequest $request)
    {
        $data = $request->validated();
        $filename = $this->imageService->save($request["photo"], $this->path);
        $data["photo"] = $filename;
        $this->repository->updateRecord($data);

        return response()->json([
            'message' => 'Autorizado guardado correctamente'
        ], 200);
    } 
}
