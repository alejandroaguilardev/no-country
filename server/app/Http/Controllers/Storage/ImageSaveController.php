<?php

namespace App\Http\Controllers\Storage;

use App\Domain\Errors\CatchException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storage\StorageSaveRequest;
use App\Services\Storage\ImageService;

final class ImageSaveController extends Controller
{
    private $path = "images/";

    public function __construct(
        private readonly ImageService $imageService
    ) {}

    public function __invoke(StorageSaveRequest $request)
    {
        try {
            $filename = $this->imageService->save($request["image"], $this->path);
            return response()->json(["filename" => $filename], 200);
        } catch (\Throwable $th) {
            $e = new CatchException($th);
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
