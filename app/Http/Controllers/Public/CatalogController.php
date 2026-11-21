<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DtMasterProduct;
use App\Models\DtMasterCategory;
use App\Services\CosineSimilarityService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    private CosineSimilarityService $cosine;

    public function __construct(CosineSimilarityService $cosine)
    {
        $this->cosine = $cosine;
    }

    // ── Halaman katalog ───────────────────────────────────
    public function index(Request $request)
    {
        $query = DtMasterProduct::with('category');

        // Pencarian keyword
        if ($request->filled('search')) {
            $kw = $request->search;
            $query->where(function ($q) use ($kw) {
                $q->where('name',        'like', "%{$kw}%")
                  ->orWhere('description','like', "%{$kw}%")
                  ->orWhere('material',   'like', "%{$kw}%");
            });
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products   = $query->latest()->paginate(12)->withQueryString();
        $categories = DtMasterCategory::withCount('products')
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('public.catalog.index', compact('products', 'categories'));
    }

    // ── Halaman detail produk ─────────────────────────────
    public function show(DtMasterProduct $product)
    {
        // Ambil Top-5 rekomendasi produk serupa
        $recommendations = $this->cosine->getTopN($product->id, 5);

        return view('public.catalog.show', compact('product', 'recommendations'));
    }
}
