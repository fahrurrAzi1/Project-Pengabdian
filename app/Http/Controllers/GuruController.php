<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        $contents = Content::all();

        return view('guru.dashboard', compact('contents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $content = new Content();
        $content->body = $request->input('content');
        $content->save();

        // Redirect ke halaman yang sama
        return redirect()->route('guru.dashboard')->with('Sukses', 'Konten berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);
        
        $content = Content::findOrFail($id);
        $content->body = $request->input('content');
        $content->save();

        return redirect()->back()->with('Sukses', 'Konten berhasil di update.');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);
        if ($content->image_path) {
            Storage::delete($content->image_path);
        }
        $content->delete();

        return redirect()->back()->with('Sukses', 'Konten berhasil di hapus.');
    }
}
