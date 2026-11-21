<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DtStopword;
use Illuminate\Http\Request;

class StopwordController extends Controller
{
    // ── Daftar stopword ──────────────────────────────────
    public function index(Request $request)
    {
        $query = DtStopword::orderBy('word');

        if ($request->filled('search')) {
            $query->where('word', 'like', '%' . $request->search . '%');
        }

        $stopwords = $query->paginate(60)->withQueryString();
        $total     = DtStopword::count();

        return view('admin.stopword.index', compact('stopwords', 'total'));
    }

    // ── Tambah satu kata ─────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:100|unique:dt_stopword,word',
        ], [
            'word.required' => 'Kata stopword wajib diisi.',
            'word.unique'   => 'Kata "' . $request->word . '" sudah ada di daftar stopword.',
        ]);

        DtStopword::create([
            'word' => strtolower(trim($request->word)),
        ]);

        return back()->with('success', 'Kata "' . $request->word . '" berhasil ditambahkan.');
    }

    // ── Tambah banyak sekaligus (bulk import) ────────────
    public function bulkStore(Request $request)
    {
        $request->validate([
            'words' => 'required|string',
        ], [
            'words.required' => 'Masukkan minimal satu kata.',
        ]);

        // Pisahkan berdasarkan koma, baris baru, atau titik koma
        $words  = preg_split('/[\s,;\n]+/', strtolower($request->words));
        $words  = array_filter(array_map('trim', $words));
        $words  = array_unique($words);

        $added   = 0;
        $skipped = 0;

        foreach ($words as $word) {
            if (strlen($word) < 2) continue;

            $exists = DtStopword::where('word', $word)->exists();
            if ($exists) {
                $skipped++;
                continue;
            }

            DtStopword::create(['word' => $word]);
            $added++;
        }

        return back()->with('success',
            "{$added} kata berhasil ditambahkan" .
            ($skipped > 0 ? ", {$skipped} kata dilewati karena sudah ada." : ".")
        );
    }

    // ── Hapus satu kata ──────────────────────────────────
    public function destroy($id)
    {
        $stopword = DtStopword::findOrFail($id);
        $word     = $stopword->word;
        $stopword->delete();

        return back()->with('success', 'Kata "' . $word . '" berhasil dihapus dari stopword.');
    }

    // ── Hapus semua & reset ke default ───────────────────
    public function reset()
    {
        $default = [
            'yang','dan','di','ke','dari','ini','itu','dengan','untuk',
            'pada','adalah','dalam','tidak','juga','ada','bisa','akan',
            'sudah','telah','dapat','oleh','atau','jika','maka','karena',
            'lebih','sangat','sekali','satu','dua','tiga','empat','lima',
            'enam','tujuh','delapan','sembilan','sepuluh','nya','lah',
            'pun','kah','namun','tetapi','tapi','bahwa','agar','supaya',
            'hingga','antara','bagi','tentang','seperti','selain','serta',
            'tersebut','setiap','semua','banyak','sedikit','sebuah',
            'berbagai','salah','beberapa','hanya','pula','lalu','kemudian',
            'lagi','saja','masih','belum','harus','perlu','boleh','mau',
            'ingin','cukup','terlalu','paling','se','cocok','mudah',
        ];

        DtStopword::truncate();

        $data = array_map(fn($w) => [
            'word'       => $w,
            'created_at' => now(),
            'updated_at' => now(),
        ], $default);

        foreach (array_chunk($data, 50) as $chunk) {
            DtStopword::insert($chunk);
        }

        return back()->with('success', 'Stopword berhasil direset ke default (' . count($default) . ' kata).');
    }
}
