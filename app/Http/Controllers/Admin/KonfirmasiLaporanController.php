<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KonfirmasiLaporanController extends Controller
{
    public function index(Request $request): View
    {
        $items = Laporan::query()
            ->with([
                "user",
                "kategori",
                "lokasi",
                "polsek",
                "konfirmasi.petugas",
            ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where("judul_laporan", "like", "%{$search}%")
                        ->orWhere("deskripsi", "like", "%{$search}%")
                        ->orWhereHas("user", function ($query) use ($search) {
                            $query
                                ->where("name", "like", "%{$search}%")
                                ->orWhere("email", "like", "%{$search}%")
                                ->orWhere("telepon", "like", "%{$search}%");
                        })
                        ->orWhereHas(
                            "kategori",
                            fn($query) => $query->where(
                                "nama_kategori",
                                "like",
                                "%{$search}%",
                            ),
                        )
                        ->orWhereHas(
                            "lokasi",
                            fn($query) => $query->where(
                                "nama_lokasi",
                                "like",
                                "%{$search}%",
                            ),
                        );
                });
            })
            ->when(
                $request->status,
                fn($query, $status) => $query->where("status", $status),
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("admin.layanan.konfirmasi.index", compact("items"));
    }

    public function update(Request $request, Laporan $laporan): RedirectResponse
    {
        $data = $request->validate([
            "status" => [
                "required",
                Rule::in(["dikonfirmasi", "ditolak", "selesai"]),
            ],
            "catatan" => ["nullable", "string", "max:1000"],
        ]);

        $laporan->update(["status" => $data["status"]]);

        $laporan->konfirmasi()->updateOrCreate(
            ["laporan_id" => $laporan->id],
            [
                "petugas_id" => Auth::id(),
                "status" => $data["status"] === "ditolak" ? "ditolak" : "valid",
                "catatan" => $data["catatan"] ?? null,
                "dikonfirmasi_pada" => now(),
            ],
        );

        return redirect()
            ->route("admin.konfirmasi-laporan.index")
            ->with("success", "Status laporan berhasil diperbarui.");
    }

    public function export(Request $request): StreamedResponse
    {
        $fileName = "konfirmasi-laporan-" . now()->format("Ymd-His") . ".csv";

        $query = Laporan::query()
            ->with([
                "user",
                "kategori",
                "lokasi",
                "polsek",
                "konfirmasi.petugas",
            ])
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where("judul_laporan", "like", "%{$search}%")
                        ->orWhereHas(
                            "user",
                            fn($query) => $query->where(
                                "name",
                                "like",
                                "%{$search}%",
                            ),
                        )
                        ->orWhereHas(
                            "kategori",
                            fn($query) => $query->where(
                                "nama_kategori",
                                "like",
                                "%{$search}%",
                            ),
                        )
                        ->orWhereHas(
                            "lokasi",
                            fn($query) => $query->where(
                                "nama_lokasi",
                                "like",
                                "%{$search}%",
                            ),
                        );
                });
            })
            ->when(
                $request->status,
                fn($query, $status) => $query->where("status", $status),
            )
            ->latest();

        return response()->streamDownload(
            function () use ($query) {
                $handle = fopen("php://output", "w");
                fputcsv($handle, [
                    "Pengirim",
                    "Email",
                    "No HP",
                    "Kategori",
                    "Kecamatan",
                    "Polsek",
                    "Judul",
                    "Status",
                    "Petugas",
                    "Tanggal",
                ]);

                $query->chunk(100, function ($laporans) use ($handle) {
                    foreach ($laporans as $laporan) {
                        fputcsv($handle, [
                            $laporan->user?->name,
                            $laporan->user?->email,
                            $laporan->user?->telepon,
                            $laporan->kategori?->nama_kategori,
                            $laporan->lokasi?->nama_lokasi,
                            $laporan->polsek?->nama,
                            $laporan->judul_laporan,
                            $laporan->status,
                            $laporan->konfirmasi?->petugas?->name,
                            Carbon::parse($laporan->created_at)->format(
                                "d/m/Y H:i",
                            ),
                        ]);
                    }
                });

                fclose($handle);
            },
            $fileName,
            ["Content-Type" => "text/csv"],
        );
    }
}
