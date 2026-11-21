<?php

namespace App\Services;

use App\Models\DtMasterProduct;
use App\Models\DtProductPreprocessing;
use App\Models\DtStopword;
use Sastrawi\Stemmer\StemmerFactory;

class PreprocessingService
{
    private $stemmer;
    private array $stopwords;

    public function __construct()
    {
        $factory       = new StemmerFactory();
        $this->stemmer = $factory->createStemmer();

        // Ambil stopword dari database (bukan hardcode)
        $this->stopwords = DtStopword::getWords();
    }



    // ── Jalankan preprocessing untuk semua produk ────────
    public function runAll(): array
    {
        $products = DtMasterProduct::all();
        $results  = ['success' => 0, 'failed' => 0, 'details' => []];

        foreach ($products as $product) {
            try {
                $this->processProduct($product);
                $results['success']++;
                $results['details'][] = "✓ {$product->name}";
            } catch (\Exception $e) {
                $results['failed']++;
                $results['details'][] = "✗ {$product->name}: " . $e->getMessage();
            }
        }

        return $results;
    }

    // ── Preprocessing satu produk ─────────────────────────
    public function processProduct(DtMasterProduct $product): DtProductPreprocessing
    {
        // Gabungkan teks dari name + description + material
        $rawText = implode(' ', [
            $product->name,
            $product->description,
            $product->material,
        ]);

        // 1. Case folding: semua huruf kecil
        $text = $this->caseFolding($rawText);

        // 2. Cleaning: hapus karakter non-alfabet
        $text = $this->cleaning($text);

        // 3. Tokenisasi: pecah jadi array kata
        $tokens = $this->tokenize($text);

        // 4. Stopword removal
        $tokens = $this->removeStopwords($tokens);

        // 5. Stemming dengan Sastrawi
        $tokens = $this->stemming($tokens);

        // 6. Hapus token kosong atau terlalu pendek (< 2 karakter)
        $tokens = array_values(array_filter($tokens, fn($t) => strlen($t) >= 2));

        // Simpan ke database (upsert berdasarkan product_id)
        $preprocessing = DtProductPreprocessing::updateOrCreate(
            ['product_id' => $product->id],
            [
                'cleaned_text' => implode(' ', $tokens),
                'tokens'       => json_encode($tokens),
                'processed_at' => now(),
            ]
        );

        return $preprocessing;
    }

    // ── Step 1: Case folding ──────────────────────────────
    private function caseFolding(string $text): string
    {
        return strtolower($text);
    }

    // ── Step 2: Cleaning ─────────────────────────────────
    private function cleaning(string $text): string
    {
        // Hapus angka
        $text = preg_replace('/\d+/', ' ', $text);
        // Hapus karakter khusus, tanda baca
        $text = preg_replace('/[^a-z\s]/', ' ', $text);
        // Hapus spasi berlebih
        $text = preg_replace('/\s+/', ' ', trim($text));
        return $text;
    }

    // ── Step 3: Tokenisasi ────────────────────────────────
    private function tokenize(string $text): array
    {
        return explode(' ', trim($text));
    }

    // ── Step 4: Stopword removal ──────────────────────────
    private function removeStopwords(array $tokens): array
    {
        return array_filter($tokens, function ($token) {
            return !in_array($token, $this->stopwords) && strlen($token) > 1;
        });
    }

    // ── Step 5: Stemming ─────────────────────────────────
    private function stemming(array $tokens): array
    {
        return array_map(function ($token) {
            return $this->stemmer->stem($token);
        }, $tokens);
    }

    // ── Ambil token sebagai array dari preprocessing ──────
    public function getTokens(DtProductPreprocessing $preprocessing): array
    {
        return json_decode($preprocessing->tokens, true) ?? [];
    }
}
