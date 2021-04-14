<?php
declare(strict_types=1);

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::post('/file/create', [FileController::class, 'createFile']);
