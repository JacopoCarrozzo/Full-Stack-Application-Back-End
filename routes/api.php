<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\PageController;
use Tapp\FilamentFormBuilder\Models\Form;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Api\FormController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('menus', [MenuController::class, 'index']);

Route::get('pages/{slug}', [PageController::class, 'show']);

Route::get('team-members', function () {
    return \App\Models\TeamMember::where('is_published', true)
        ->orderBy('sort_order')
        ->get();
});

Route::get('/forms/{id}', [FormController::class, 'show']);

Route::post('/forms/{id}/submit', [FormController::class, 'submit']);