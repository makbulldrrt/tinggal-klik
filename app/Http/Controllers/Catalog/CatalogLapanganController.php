<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Lapangan;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * CatalogLapanganController
 *
 * Powers the public-facing court catalog at GET /lapangan.
 *
 * Blade contract (Mahdi's index.blade.php):
 *   $courts  — LengthAwarePaginator<Lapangan>
 *              Must expose: id, nama_lapangan, jenis_olahraga, harga_per_jam,
 *                           foto_lapangan, status, lokasi, owner (relation)
 *
 * Query parameters consumed from the request:
 *   ?search=<string>  — LIKE filter on nama_lapangan
 *   ?jenis=<string>   — exact match on jenis_olahraga ('semua' = no filter)
 *   ?page=<int>       — handled automatically by paginate()
 *
 * Module: Modul 2 — Front End, Katalog & Pencarian (PJ: Mahdi / Backend support)
 * Blueprint: STARTUP_BLUEPRINT.md §3 Modul 2
 */
class CatalogLapanganController extends Controller
{
    /**
     * Number of court cards to display per page.
     * Matches the 3-column grid (3 × 3 = 9 looks great; 6 is also fine for MVP).
     */
    private const PER_PAGE = 9;

    /**
     * Display the public court catalog with search & category filtering.
     *
     * Eager-loads the `owner` relation in a single JOIN query to avoid
     * N+1 issues when the blade reads $court->owner->name / nama_bisnis.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        // ── 1. Sanitise inputs ────────────────────────────────────────────────
        // strip_tags prevents XSS if the value ever reaches a raw output.
        $search = trim(strip_tags($request->query('search', '')));
        $jenis  = trim(strip_tags($request->query('jenis',  'semua')));

        // ── 2. Build query with local scopes ──────────────────────────────────
        // Both scopes use the when() helper so no query is mutated when the
        // parameter is absent. The scopes live on the Lapangan model.
        $courts = Lapangan::query()
            // Eager-load the owner to prevent N+1.
            // The blade reads: $court->owner->name (and optionally nama_bisnis)
            ->with('owner:id,name')          // SELECT only the columns we need
            // Apply search filter (scoped on the model)
            ->searchNama($search)
            // Apply jenis_olahraga filter (scoped on the model)
            ->jenisOlahraga($jenis)
            // Always show newest courts first (owners want their new listings visible)
            ->latest()
            // Paginate — appends ?search & ?jenis automatically via $courts->appends()
            ->paginate(self::PER_PAGE)
            // Preserve all current query-string parameters in page links
            ->withQueryString();

        // ── 3. Return the view ────────────────────────────────────────────────
        // Variable name MUST be $courts — do NOT rename, Mahdi's blade depends on it.
        return view('lapangan.index', compact('courts'));
    }
}
