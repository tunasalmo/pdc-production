<?php

namespace App\Services;

use App\Models\DtMasterProduct;
use App\Models\DtProductPreprocessing;
use App\Models\DtProductNormalization;

class TFIDFService
{
    // ── Jalankan TF-IDF untuk semua produk ───────────────
    public function runAll(): array
    {
        $preprocessings = DtProductPreprocessing::with('product')->get();

        if ($preprocessings->isEmpty()) {
            return ['success' => 0, 'error' => 'Belum ada data preprocessing. Jalankan preprocessing dulu.'];
        }

        // Kumpulkan semua token per produk
        $corpus = [];
        foreach ($preprocessings as $prep) {
            $tokens = json_decode($prep->tokens, true) ?? [];
            $corpus[$prep->product_id] = $tokens;
        }

        // Hitung IDF dari seluruh corpus
        $idf = $this->computeIDF($corpus);

        // Hitung TF-IDF per produk dan simpan
        $results = ['success' => 0, 'failed' => 0, 'details' => []];

        foreach ($corpus as $productId => $tokens) {
            try {
                $tf       = $this->computeTF($tokens);
                $tfidf    = $this->computeTFIDF($tf, $idf);
                $terms    = array_keys($tfidf);

                DtProductNormalization::updateOrCreate(
                    ['product_id' => $productId],
                    [
                        'tfidf_vector' => json_encode($tfidf),
                        'terms'        => json_encode($terms),
                        'normalized_at'=> now(),
                    ]
                );

                $results['success']++;
                $results['details'][] = "✓ Product ID {$productId} ({$tf['__total']} term)";
            } catch (\Exception $e) {
                $results['failed']++;
                $results['details'][] = "✗ Product ID {$productId}: " . $e->getMessage();
            }
        }

        return $results;
    }

    // ── Hitung Term Frequency (TF) ────────────────────────
    // TF = jumlah kemunculan term / total term dalam dokumen
    public function computeTF(array $tokens): array
    {
        $total  = count($tokens);
        $counts = array_count_values($tokens);
        $tf     = [];

        foreach ($counts as $term => $count) {
            $tf[$term] = $count / $total;
        }

        // Simpan total untuk info, lalu hapus sebelum return
        $tf['__total'] = $total;

        return $tf;
    }

    // ── Hitung Inverse Document Frequency (IDF) ───────────
    // IDF = log(N / df) + 1
    // N   = jumlah dokumen, df = dokumen yang mengandung term
    public function computeIDF(array $corpus): array
    {
        $N          = count($corpus);
        $docFreq    = [];

        // Hitung berapa dokumen yang mengandung setiap term
        foreach ($corpus as $tokens) {
            $uniqueTerms = array_unique($tokens);
            foreach ($uniqueTerms as $term) {
                $docFreq[$term] = ($docFreq[$term] ?? 0) + 1;
            }
        }

        // Hitung IDF
        $idf = [];
        foreach ($docFreq as $term => $df) {
            $idf[$term] = log($N / $df) + 1;
        }

        return $idf;
    }

    // ── Hitung TF-IDF ─────────────────────────────────────
    // TF-IDF = TF × IDF
    public function computeTFIDF(array $tf, array $idf): array
    {
        $tfidf = [];

        foreach ($tf as $term => $tfValue) {
            if ($term === '__total') continue;  // Skip marker internal
            if (isset($idf[$term])) {
                $score = $tfValue * $idf[$term];
                if ($score > 0) {
                    $tfidf[$term] = round($score, 6);
                }
            }
        }

        // Urutkan dari bobot tertinggi
        arsort($tfidf);

        return $tfidf;
    }

    // ── Ambil semua vektor TF-IDF dari DB ─────────────────
    public function getAllVectors(): array
    {
        $normalizations = DtProductNormalization::all();
        $vectors        = [];

        foreach ($normalizations as $norm) {
            $vectors[$norm->product_id] = json_decode($norm->tfidf_vector, true) ?? [];
        }

        return $vectors;
    }
}
