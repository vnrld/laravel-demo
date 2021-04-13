<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Filesystem\Storage;
use Illuminate\Http\JsonResponse;
use Px\Framework\Http\Responder\Response;

class DateController extends Controller
{
    public function saveDateToFile(): JsonResponse
    {
        $storage = new Storage();
        $storage->put('test.txt', 'Photo: ' . date('Y-m-d H:i:s'));

        $response = new Response();
        $response->setContent([$storage->get('test.txt')]);
        return $response->json();
    }

}
