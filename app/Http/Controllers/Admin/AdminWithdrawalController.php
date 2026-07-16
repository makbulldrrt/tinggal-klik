<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $withdrawals = Withdrawal::with('user')
            ->when($search, function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Pengajuan penarikan dana berhasil disetujui.');
    }

    public function reject($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);
        $withdrawal->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Pengajuan penarikan dana berhasil ditolak.');
    }
}
