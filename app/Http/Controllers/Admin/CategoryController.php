<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $jenis = $this->selectedJenis($request);

        $items = Category::query()
            ->where("jenis", $jenis)
            ->when(
                $request->search,
                fn($query, $search) => $query->where(function ($query) use (
                    $search,
                ) {
                    $query
                        ->where("nama_kategori", "like", "%{$search}%")
                        ->orWhere("warna_marker", "like", "%{$search}%");
                }),
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("admin.master.kategori.index", compact("items", "jenis"));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        Category::create($data);

        return redirect()
            ->route("admin.categories.index", ["jenis" => $data["jenis"]])
            ->with("success", "Kategori berhasil ditambahkan.");
    }

    public function update(
        Request $request,
        Category $category,
    ): RedirectResponse {
        $data = $this->validated($request);

        $category->update($data);

        return redirect()
            ->route("admin.categories.index", ["jenis" => $data["jenis"]])
            ->with("success", "Kategori berhasil diperbarui.");
    }

    public function destroy(Category $category): RedirectResponse
    {
        $jenis = $category->jenis;
        $category->delete();

        return redirect()
            ->route("admin.categories.index", ["jenis" => $jenis])
            ->with("success", "Kategori berhasil dihapus.");
    }

    private function validated(Request $request): array
    {
        return $request->validate(
            [
                "nama_kategori" => ["required", "string", "max:255"],
                "jenis" => ["required", Rule::in(["kejahatan", "kecelakaan"])],
                "warna_marker" => [
                    "required",
                    "string",
                    "max:20",
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],
            ],
            [
                "warna_marker.regex" =>
                    "Warna marker harus menggunakan format hex, contoh #FF0000.",
            ],
        );
    }

    private function selectedJenis(Request $request): string
    {
        $jenis = $request->query("jenis", $request->query("tipe"));

        return in_array($jenis, ["kejahatan", "kecelakaan"], true)
            ? $jenis
            : "kejahatan";
    }
}
