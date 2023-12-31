<?php

use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserPreferenceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get("/run-artisan", function () {
    try {
        Artisan::call('migrate', [
            '--force' => true,
        ]);
        // Artisan::call("storage:link");
        // Artisan::call("l5-swagger:generate");
        return response()->json([
            "message" => "Artisan commands ran succcessfully"
        ], 200);
    } catch (\Throwable $th) {
        return response()->json([
            "error" => "Failed to run artisan commands " . $th->getMessage()
        ], 500);
    }
});

Route::prefix('auth')->group(function () {
    Route::post("/signup", [UserController::class, "store"]);
    Route::post("/login", [UserController::class, "login"]);
    Route::post("/logout", [UserController::class, "logout"]);
});

Route::prefix('user')->group(function () {
    Route::get("/", [UserController::class, "show"]);
});

Route::prefix('news')->group(function () {
    Route::post("/search", [NewsController::class, "search"]);
    Route::get("/", [NewsController::class, "index"]);
});

Route::prefix('preference')->group(function () {
    Route::post("/", [UserPreferenceController::class, "store"]);
    Route::get("/", [UserPreferenceController::class, "show"]);
});
