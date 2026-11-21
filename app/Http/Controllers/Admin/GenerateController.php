<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PreprocessingService;
use App\Services\TFIDFService;
use App\Services\CosineSimilarityService;
use App\Models\DtMasterProduct;
use App\Models\DtProductPreprocessing;
use App\Models\DtProductNormalization;
use App\Models\DtSimilarityScore;

class GenerateController extends Controller
{
    private PreprocessingService   $preprocessing;
    private TFIDFService           $tfidf;
    private CosineSimilarityService $cosine;

    public function __construct(
        PreprocessingService    $preprocessing,
        TFIDFService            $tfidf,
        CosineSimilarityService $cosine
    ) {
        $this->preprocessing = $preprocessing;
        $this->tfidf         = $tfidf;
        $this->cosine        = $cosine;
    }

    // ── Halaman generate ─────────────────────────────────
    public function index()
    {
        $stats = [
            'total_products'       => DtMasterProduct::count(),
            'preprocessed'         => DtProductPreprocessing::count(),
            'normalized'           => DtProductNormalization::count(),
            'similarity_pairs'     => DtSimilarityScore::count(),
        ];

        // Ambil sample hasil preprocessing
        $preprocessingSample = DtProductPreprocessing::with('product')
            ->latest('processed_at')
            ->take(5)
            ->get();

        // Ambil sample top similarity
        $similaritySample = DtSimilarityScore::with(['productA', 'productB'])
            ->orderBy('cosine_score', 'desc')
            ->take(10)
            ->get();

        return view('admin.generate.index', compact(
            'stats', 'preprocessingSample', 'similaritySample'
        ));
    }

    // ── Jalankan SEMUA proses sekaligus ──────────────────
    public function run()
    {
        $log = [];

        try {
            // Step 1: Preprocessing
            $log[] = '=== STEP 1: PREPROCESSING ===';
            $r1    = $this->preprocessing->runAll();
            $log   = array_merge($log, $r1['details']);
            $log[] = "Selesai: {$r1['success']} produk diproses.";

            // Step 2: TF-IDF
            $log[] = '';
            $log[] = '=== STEP 2: NORMALISASI TF-IDF ===';
            $r2    = $this->tfidf->runAll();
            if (isset($r2['error'])) {
                $log[] = '✗ ' . $r2['error'];
            } else {
                $log   = array_merge($log, $r2['details']);
                $log[] = "Selesai: {$r2['success']} vektor TF-IDF dihitung.";
            }

            // Step 3: Cosine Similarity
            $log[] = '';
            $log[] = '=== STEP 3: COSINE SIMILARITY ===';
            $r3    = $this->cosine->runAll();
            if (isset($r3['error'])) {
                $log[] = '✗ ' . $r3['error'];
            } else {
                $log   = array_merge($log, $r3['details']);
                $log[] = "Selesai: {$r3['pairs']} pasang produk dihitung.";
            }

            $log[] = '';
            $log[] = '✓ SEMUA PROSES SELESAI';

            session(['generate_log' => $log, 'generate_status' => 'success']);

        } catch (\Exception $e) {
            $log[] = '✗ ERROR: ' . $e->getMessage();
            session(['generate_log' => $log, 'generate_status' => 'error']);
        }

        return redirect()->route('admin.generate.index')
            ->with('success', 'Generate selesai! Cek log di bawah.');
    }

    // ── Jalankan hanya preprocessing ─────────────────────
    public function preprocessing()
    {
        try {
            $result = $this->preprocessing->runAll();
            session(['generate_log' => $result['details'], 'generate_status' => 'success']);
            return redirect()->route('admin.generate.index')
                ->with('success', "Preprocessing selesai: {$result['success']} produk diproses.");
        } catch (\Exception $e) {
            return redirect()->route('admin.generate.index')
                ->with('error', 'Preprocessing gagal: ' . $e->getMessage());
        }
    }

    // ── Jalankan hanya normalisasi TF-IDF ────────────────
    public function normalization()
    {
        try {
            $result = $this->tfidf->runAll();
            if (isset($result['error'])) {
                return redirect()->route('admin.generate.index')->with('error', $result['error']);
            }
            session(['generate_log' => $result['details'], 'generate_status' => 'success']);
            return redirect()->route('admin.generate.index')
                ->with('success', "Normalisasi TF-IDF selesai: {$result['success']} produk.");
        } catch (\Exception $e) {
            return redirect()->route('admin.generate.index')
                ->with('error', 'Normalisasi gagal: ' . $e->getMessage());
        }
    }

    // ── Jalankan hanya cosine similarity ─────────────────
    public function similarity()
    {
        try {
            $result = $this->cosine->runAll();
            if (isset($result['error'])) {
                return redirect()->route('admin.generate.index')->with('error', $result['error']);
            }
            session(['generate_log' => $result['details'], 'generate_status' => 'success']);
            return redirect()->route('admin.generate.index')
                ->with('success', "Cosine similarity selesai: {$result['pairs']} pasang dihitung.");
        } catch (\Exception $e) {
            return redirect()->route('admin.generate.index')
                ->with('error', 'Cosine similarity gagal: ' . $e->getMessage());
        }
    }
}
