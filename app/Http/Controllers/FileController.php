<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\User\NotAuthenticatedException;
use App\Http\Requests\File\FileRequest;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Px\Framework\Http\Responder\Response;

class FileController extends Controller
{
    public function createFile(FileRequest $fileRequest): JsonResponse
    {
        $response = new Response();

        if (!$fileRequest->validated()) {
            throw new NotAuthenticatedException('Canbno');
        }

        $disk = $fileRequest->getDisk();
        $file = $fileRequest->getFilename();

        $targetFile = $fileRequest->getSavePath() . '/' . basename($file);

        if (file_exists($file)) {
            $fileObj = new File($file);
            $isCreated = $disk->putFile($fileRequest->getSavePath(), $fileObj, $fileObj->getBasename());
        } else {
            $isCreated = $disk->put($targetFile, $fileRequest->getContents());
        }

        if ($fileRequest->isInS3()) {
            $path = $disk->url($targetFile);
        } else {
            $path = $disk->path($targetFile);
        }

        $response = new Response();
        $response->setContent(
            [
                'is_created' => $isCreated,
                'created_at' => date('c'),
                'path' => $path
            ]
        );
        return $response->json();
    }

}
