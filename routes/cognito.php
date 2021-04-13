<?php
declare(strict_types=1);

use App\Http\Controllers\CognitoController;
use Illuminate\Support\Facades\Route;

Route::get('/userpools/all/{max_results}', [CognitoController::class, 'listUserPools']);
