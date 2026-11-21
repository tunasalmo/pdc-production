<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DtMasterProduct;
use App\Models\DtMasterCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ── Daftar produk ────────────────────────────────────
    public function index(Request $request)
    {
        $query = DtMasterProduct::with('category');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products   = $query->latest()->paginate(10)->withQueryString();
        $categories = DtMasterCategory::orderBy('name')->get();

        return view('admin.product.index', compact('products', 'categories'));
    }

    // ── Form tambah produk ───────────────────────────────
    public function create()
    {
        $categories = DtMasterCategory::orderBy('name')->get();
        return view('admin.product.create', compact('categories'));
    }

    // ── Simpan produk baru ───────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:200',
            'category_id' => 'required|exists:dt_master_category,id',
            'description' => 'required|string',
            'material'    => 'required|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required'        => 'Nama produk wajib diisi.',
            'category_id.required' => 'Kategori wajib dipilih.',
            'description.required' => 'Deskripsi wajib diisi.',
            'material.required'    => 'Material wajib diisi.',
            'price.required'       => 'Harga wajib diisi.',
            'image.image'          => 'File harus berupa gambar.',
            'image.max'            => 'Ukuran gambar maksimal 2MB.',
        ]);

        $image_url = null;

        // Upload gambar jika ada
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/products'), $filename);
            $image_url = 'uploads/products/' . $filename;
        }

        DtMasterProduct::create([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'material'    => $request->material,
            'price'       => $request->price,
            'image_url'   => $image_url,
        ]);

        return redirect()->route('admin.product.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // ── Form edit produk ─────────────────────────────────
    public function edit(DtMasterProduct $product)
    {
        $categories = DtMasterCategory::orderBy('name')->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    // ── Update produk ────────────────────────────────────
    public function update(Request $request, DtMasterProduct $product)
    {
        $request->validate([
            'name'        => 'required|string|max:200',
            'category_id' => 'required|exists:dt_master_category,id',
            'description' => 'required|string',
            'material'    => 'required|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image_url = $product->image_url;

        // Ganti gambar jika ada upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($image_url && file_exists(public_path($image_url))) {
                unlink(public_path($image_url));
            }
            $file      = $request->file('image');
            $filename  = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/products'), $filename);
            $image_url = 'uploads/products/' . $filename;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'material'    => $request->material,
            'price'       => $request->price,
            'image_url'   => $image_url,
        ]);

        return redirect()->route('admin.product.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // ── Hapus produk ─────────────────────────────────────
    public function destroy(DtMasterProduct $product)
    {
        // Hapus gambar
        if ($product->image_url && file_exists(public_path($product->image_url))) {
            unlink(public_path($product->image_url));
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
