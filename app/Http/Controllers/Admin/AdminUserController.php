<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $items = User::query()
            ->when(
                $request->search,
                fn($query, $search) => $query->where(function ($query) use (
                    $search,
                ) {
                    $query
                        ->where("name", "like", "%{$search}%")
                        ->orWhere("username", "like", "%{$search}%")
                        ->orWhere("email", "like", "%{$search}%")
                        ->orWhere("telepon", "like", "%{$search}%")
                        ->orWhere("role", "like", "%{$search}%");
                }),
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view("admin.master.users.index", compact("items"));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data["password"] = Hash::make($data["password"]);

        User::create($data);

        return redirect()
            ->route("admin.users.index")
            ->with("success", "User berhasil ditambahkan.");
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validated($request, $user);

        if (!empty($data["password"])) {
            $data["password"] = Hash::make($data["password"]);
        } else {
            unset($data["password"]);
        }

        $user->update($data);

        return redirect()
            ->route("admin.users.index")
            ->with("success", "User berhasil diperbarui.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->is(auth()->user())) {
            return redirect()
                ->route("admin.users.index")
                ->with("error", "User yang sedang login tidak dapat dihapus.");
        }

        $user->delete();

        return redirect()
            ->route("admin.users.index")
            ->with("success", "User berhasil dihapus.");
    }

    private function validated(Request $request, ?User $user = null): array
    {
        $userId = $user?->id;

        $data = $request->validate([
            "name" => ["required", "string", "max:255"],
            "username" => [
                "nullable",
                "string",
                "max:100",
                Rule::unique("users", "username")->ignore($userId),
            ],
            "email" => [
                "required",
                "email",
                "max:255",
                Rule::unique("users", "email")->ignore($userId),
            ],
            "telepon" => ["nullable", "string", "max:30"],
            "alamat" => ["nullable", "string", "max:255"],
            "role" => [
                "required",
                "string",
                Rule::in(["admin", "operator", "user"]),
            ],
            "aktif" => ["nullable", "boolean"],
            "password" => [$user ? "nullable" : "required", "string", "min:8"],
        ]);

        $data["aktif"] = $request->boolean("aktif");

        return $data;
    }
}
