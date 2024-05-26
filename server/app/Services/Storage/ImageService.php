<?php

namespace App\Services\Storage;

use App\Domain\Errors\ErrorDomain;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

final class ImageService
{
    public function save($image, string $path)
    {
        $this->ensurePathExists($path);
        $filename = time() . "." . $image->getClientOriginalExtension();

        $imageRead = Image::read($image);
        $imageRead->scale(600, 600, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
            ->save(Storage::path($path . $filename));
        return $filename;
    }

    public function search(string $name, string $path)
    {
        $imagePath = Storage::path($path . $name);
        $this->ensureFileExists($imagePath);

        $file = File::get($imagePath);
        $type = File::mimeType($imagePath);

        return [
            "file" => $file,
            "type" => $type,
        ];
    }

    public function remove(string $name, string $path): void
    {
        $imagePath = Storage::path($path . $name);
        $this->ensureFileExists($imagePath);
        File::delete($imagePath);
    }

    private function ensureFileExists($imagePath)
    {
        if (!File::exists($imagePath)) {
            throw new ErrorDomain("Imagen no encontrada", 404);
        }
    }

    private function ensurePathExists(string $path): void
    {
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
    }
}
