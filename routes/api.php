<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MapDataController;
use App\Http\Controllers\Api\MasyarakatApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Enjoy building your API!
|
*/

// --- Admin/Map API Routes ---
Route::get("/map/statistics", [MapDataController::class, "getStatistics"]);

Route::middleware(["auth:sanctum"])->group(function () {
    // --- Auth API Routes ---
    Route::get("/user", function (Request $request) {
        return new UserResource($request->user());
    });
    Route::post("/auth/logout", [AuthController::class, "logout"]);
    Route::get("/auth/me", [AuthController::class, "me"]); // To get current user info

    // --- Masyarakat API Routes ---
    Route::get("/overview", [MasyarakatApiController::class, "overview"]);
    Route::get("/home", [MasyarakatApiController::class, "home"]);
    Route::get("/cctvs", [MasyarakatApiController::class, "cctvs"]);
    Route::get("/reports", [MasyarakatApiController::class, "reports"]);
    Route::get("/reports/create-options", [
        MasyarakatApiController::class,
        "reportOptions",
    ]);
    Route::post("/reports", [MasyarakatApiController::class, "storeReport"]);
    Route::get("/sos", [MasyarakatApiController::class, "sos"]);
    Route::post("/sos", [MasyarakatApiController::class, "storeSos"]);
    Route::get("/news", [MasyarakatApiController::class, "news"]);
    Route::get("/news/{news}", [MasyarakatApiController::class, "showNews"]);
    Route::get("/profile", [MasyarakatApiController::class, "profile"]);

    // --- Profile API Routes (for editing/deleting) ---
    Route::prefix("profile")->group(function () {
        Route::get("/edit", [MasyarakatApiController::class, "editProfile"]);
        Route::put("/", [MasyarakatApiController::class, "updateProfile"]);
        Route::delete("/", [MasyarakatApiController::class, "destroyProfile"]);
    });
});

// --- Public Auth API Routes ---
Route::post("/auth/register", [AuthController::class, "register"]);
Route::post("/auth/login", [AuthController::class, "login"]);
