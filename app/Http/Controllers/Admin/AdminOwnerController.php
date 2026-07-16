<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOwnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $owners = User::where('role', 'owner')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nama_bisnis', 'like', '%' . $search . '%');
                });
            })
            ->withCount('lapangan')
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.owners.index', compact('owners'));
    }
}
