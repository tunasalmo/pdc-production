<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DtMasterProduct;
use App\Models\DtMasterCategory;
use App\Models\DtSimilarityScore;
use App\Models\DtProductNormalization;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'   => DtMasterProduct::count(),
            'total_categories' => DtMasterCategory::count(),
            'total_similarity' => DtSimilarityScore::count(),
            'tfidf_status'     => DtProductNormalization::count() > 0 ? 'Aktif' : 'Belum di-generate',
        ];

        $latest_products = DtMasterProduct::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latest_products'));
    }
}
