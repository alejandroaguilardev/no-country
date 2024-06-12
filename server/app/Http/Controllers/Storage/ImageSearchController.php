<?php

namespace App\Http\Controllers\Storage;

use App\Domain\Errors\CatchException;
use App\Http\Controllers\Controller;
use App\Services\Storage\ImageService;

final class ImageSearchController extends Controller
{
    private $path = "images/";

    public function __construct(
        private readonly ImageService $imageService
    ) {}

    public function __invoke(string $name)
    {
        try {
            $image = $this->imageService->search($name, $this->path);

            return response($image["file"], 200)
                ->header('Content-Type', $image["type"]);
        } catch (\Throwable $e) {
            $e = new CatchException($e);
            return response()->json($e->getMessage(), $e->getCode());
        }
    }
}
