<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;

class QuestController extends Controller
{
    public function store(Request $request)
    {
        // Validasi konten
        $request->validate([
            'content' => 'required|string',
        ]);

        // Simpan konten ke database atau lakukan tindakan lainnya
        // Contoh menyimpan ke database
        $quest = new Content();
        $quest->body = $request->input('content');
        $quest->save();

        // Redirect ke halaman yang sama
        return redirect()->route('guru.dashboard')->with('success', 'Konten berhasil disimpan!');
    }
}
