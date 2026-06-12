<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CctvController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KonfirmasiLaporanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PolsekController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Masyarakat\MasyarakatController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return view("welcome");
})->name("landing");

$pwaManifestResponse = function () {
    $path = public_path("build/manifest.webmanifest");

    if (!File::exists($path)) {
        $path = public_path("manifest.webmanifest");
    }

    abort_unless(File::exists($path), 404);

    return response(File::get($path), 200, [
        "Content-Type" => "application/manifest+json; charset=UTF-8",
        "Cache-Control" => "no-cache, no-store, must-revalidate",
    ]);
};

Route::get("/pwa-manifest.webmanifest", $pwaManifestResponse)->name(
    "pwa.manifest",
);
Route::get("/manifest.webmanifest", $pwaManifestResponse);

Route::get("/sw.js", function () {
    $path = public_path("sw.js");

    abort_unless(File::exists($path), 404);

    return response(File::get($path), 200, [
        "Content-Type" => "application/javascript; charset=UTF-8",
        "Cache-Control" => "no-cache, no-store, must-revalidate",
        "Service-Worker-Allowed" => "/",
    ]);
});

Route::get("/icons/{file}", function (string $file) {
    abort_unless(
        preg_match('/^[A-Za-z0-9._-]+\\.(png|svg)$/', $file) === 1,
        404,
    );

    $path = public_path("icons/{$file}");

    abort_unless(File::exists($path), 404);

    return response(File::get($path), 200, [
        "Content-Type" => File::mimeType($path) ?: "application/octet-stream",
        "Cache-Control" => "public, max-age=3600",
    ]);
});

Route::get("/pwa", [MasyarakatController::class, "overview"])
    ->middleware("prevent-back-history")
    ->name("masyarakat.overview");

Route::middleware(["auth", "verified", "prevent-back-history"])->group(function () {
    Route::get("/dashboard", function () {
        return Auth::user()?->role === "user"
            ? redirect()->route("masyarakat.home")
            : app(DashboardController::class)->__invoke();
    })->name("dashboard");

    Route::prefix("masyarakat")
        ->name("masyarakat.")
        ->controller(MasyarakatController::class)
        ->group(function () {
            Route::get("/home", "home")->name("home");
            Route::get("/cctv", "cctv")->name("cctv");
            Route::get("/laporan", "laporan")->name("laporan.index");
            Route::get("/laporan/buat", "createLaporan")->name(
                "laporan.create",
            );
            Route::post("/laporan", "storeLaporan")->name("laporan.store");
            Route::get("/laporan/{laporan}", "showLaporan")->name("laporan.show");
            Route::get("/sos", "sos")->name("sos");
            Route::post("/sos", "storeSos")->name("sos.store");
            Route::get("/berita", "berita")->name("berita.index");
            Route::get("/berita/{berita}", "showBerita")->name("berita.show");
            Route::get("/profile", "profile")->name("profile");
            Route::get("/profile/edit", "editProfile")->name("profile.edit");
            Route::patch("/profile/edit", "updateProfile")->name("profile.update");
            Route::put("/profile/password", "updatePassword")->name("profile.password");
            Route::get("/bantuan", "bantuan")->name("bantuan");
        });

    Route::prefix("admin")
        ->name("admin.")
        ->group(function () {
            Route::resource("users", AdminUserController::class)->only([
                "index",
                "store",
                "update",
                "destroy",
            ]);
            Route::resource("polseks", PolsekController::class)->only([
                "index",
                "store",
                "update",
                "destroy",
            ]);
            Route::resource("categories", CategoryController::class)->only([
                "index",
                "store",
                "update",
                "destroy",
            ]);
            Route::resource("cctvs", CctvController::class);
            Route::resource("locations", LocationController::class)->only([
                "index",
                "store",
                "update",
                "destroy",
            ]);

            Route::get("konfirmasi-laporan/export", [
                KonfirmasiLaporanController::class,
                "export",
            ])->name("konfirmasi-laporan.export");
            Route::get("konfirmasi-laporan", [
                KonfirmasiLaporanController::class,
                "index",
            ])->name("konfirmasi-laporan.index");
            Route::patch("konfirmasi-laporan/{laporan}", [
                KonfirmasiLaporanController::class,
                "update",
            ])->name("konfirmasi-laporan.update");

            Route::get("laporan/infografik", [
                LaporanController::class,
                "infografik",
            ])->name("laporan.infografik");
            Route::get("laporan/riwayat", [
                LaporanController::class,
                "riwayat",
            ])->name("laporan.riwayat");
            Route::get("laporan/darurat/status", [
                LaporanController::class,
                "daruratStatus",
            ])->name("laporan.darurat.status");
            Route::get("laporan/darurat", [
                LaporanController::class,
                "darurat",
            ])->name("laporan.darurat");
            Route::post("laporan/darurat", [
                LaporanController::class,
                "storeDarurat",
            ])->name("laporan.darurat.store");
            Route::patch("laporan/darurat/{emergencyReport}/dispatch", [
                LaporanController::class,
                "dispatchDarurat",
            ])->name("laporan.darurat.dispatch");
            Route::patch("laporan/darurat/{emergencyReport}/complete", [
                LaporanController::class,
                "completeDarurat",
            ])->name("laporan.darurat.complete");

            Route::patch("berita/{berita}/publish", [
                BeritaController::class,
                "publish",
            ])->name("berita.publish");
            Route::patch("berita/{berita}/draft", [
                BeritaController::class,
                "draft",
            ])->name("berita.draft");
            Route::resource("berita", BeritaController::class)->only([
                "index",
                "store",
                "update",
                "destroy",
            ]);
        });

    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );
    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
    Route::delete("/profile", [ProfileController::class, "destroy"])->name(
        "profile.destroy",
    );
});

require __DIR__ . "/auth.php";
