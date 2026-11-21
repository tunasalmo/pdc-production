<?php

namespace App\Services;

use App\Models\DtProductNormalization;
use App\Models\DtSimilarityScore;

class CosineSimilarityService
{
    // ── Hitung cosine similarity semua pasang produk ──────
    public function runAll(): array
    {
        $normalizations = DtProductNormalization::all();

        if ($normalizations->count() < 2) {
            return [
                'success' => 0,
                'error'   => 'Minimal 2 produk yang sudah dinormalisasi untuk menghitung similarity.',
            ];
        }

        // Ambil semua vektor TF-IDF
        $vectors = [];
        foreach ($normalizations as $norm) {
            $vectors[$norm->product_id] = json_decode($norm->tfidf_vector, true) ?? [];
        }

        $productIds = array_keys($vectors);
        $total      = count($productIds);
        $results    = ['success' => 0, 'pairs' => 0, 'details' => []];

        // Hapus data similarity lama sebelum generate ulang
        DtSimilarityScore::truncate();

        // Hitung semua kombinasi pasangan (tanpa duplikat)
        $batch = [];
        for ($i = 0; $i < $total; $i++) {
            for ($j = $i + 1; $j < $total; $j++) {
                $idA   = $productIds[$i];
                $idB   = $productIds[$j];
                $score = $this->cosine($vectors[$idA], $vectors[$idB]);

                $batch[] = [
                    'product_a_id' => $idA,
                    'product_b_id' => $idB,
                    'cosine_score' => round($score, 6),
                    'computed_at'  => now(),
                ];

                // Insert per batch 100 untuk efisiensi
                if (count($batch) >= 100) {
                    DtSimilarityScore::insert($batch);
                    $results['pairs'] += count($batch);
                    $batch = [];
                }
            }
        }

        // Insert sisa batch
        if (!empty($batch)) {
            DtSimilarityScore::insert($batch);
            $results['pairs'] += count($batch);
        }

        $results['success'] = 1;
        $results['details'][] = "✓ {$results['pairs']} pasang produk dihitung";
        $results['details'][] = "✓ {$total} produk · " . ($total * ($total - 1) / 2) . " kombinasi";

        return $results;
    }

    // ── Rumus cosine similarity ───────────────────────────
    // cos(θ) = (A · B) / (|A| × |B|)
    public function cosine(array $vecA, array $vecB): float
    {
        // Dot product: A · B
        $dotProduct = 0.0;
        foreach ($vecA as $term => $weightA) {
            if (isset($vecB[$term])) {
                $dotProduct += $weightA * $vecB[$term];
            }
        }

        // Magnitude: |A|
        $magnitudeA = sqrt(array_sum(array_map(fn($w) => $w * $w, $vecA)));

        // Magnitude: |B|
        $magnitudeB = sqrt(array_sum(array_map(fn($w) => $w * $w, $vecB)));

        // Hindari division by zero
        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0.0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

    // ── Ambil Top-N rekomendasi untuk satu produk ─────────
    public function getTopN(int $productId, int $n = 5): array
    {
        // Cari pasangan di mana produk ini ada di sisi A atau B
        $scores = DtSimilarityScore::where(function ($q) use ($productId) {
                $q->where('product_a_id', $productId)
                  ->orWhere('product_b_id', $productId);
            })
            ->orderBy('cosine_score', 'desc')
            ->take($n)
            ->with(['productA', 'productB'])
            ->get();

        $recommendations = [];
        foreach ($scores as $score) {
            // Ambil produk yang BUKAN produk yang dicari
            $recommended = $score->product_a_id == $productId
                ? $score->productB
                : $score->productA;

            if ($recommended) {
                $recommended->cosine_score = $score->cosine_score;
                $recommendations[]         = $recommended;
            }
        }

        return $recommendations;
    }
}
