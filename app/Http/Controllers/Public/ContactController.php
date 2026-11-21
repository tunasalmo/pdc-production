<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string|min:10',
        ], [
            'name.required'    => 'Nama wajib diisi.',
            'email.required'   => 'Email wajib diisi.',
            'email.email'      => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min'      => 'Pesan minimal 10 karakter.',
        ]);

        // Opsional: kirim email notifikasi ke admin
        // Mail::to('info@pdcproduction.com')->send(new ContactMail($request->all()));

        // Atau simpan ke database jika dibutuhkan
        // ContactMessage::create($request->only(['name','email','phone','topic','message']));

        return back()->with('success',
            'Pesan berhasil dikirim! Kami akan menghubungi Anda segera.'
        );
    }
}
