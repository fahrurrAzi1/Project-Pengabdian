<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    public function index()
    {
        // $contents = Content::all();

        // $contents = Content::with('jawabans.user')->get();

        $teacherId = Auth::user()->id;

        $contents = Content::where('teacher_id', $teacherId)->get();

        return view('guru.dashboard', compact('contents', 'teacherId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'teacher_id' => 'required|exists:users,id'
        ]);

        $content = new Content();
        $content->body = $request->input('content');
        $content->teacher_id = $request->input('teacher_id');
        $content->save();

        // Redirect ke halaman yang sama
        return redirect()->route('guru.dashboard')->with('Sukses', 'Konten berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
            'teacher_id' => 'required|exists:users,id'
        ]);
        
        $content = Content::findOrFail($id);
        $content->body = $request->input('content');
        $content->teacher_id = $request->input('teacher_id');
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

    public function markAnswer(Request $request, $id)
    {
        $status = $request->input('status');

        $jawaban = Jawaban::find($id);
        if (!$jawaban) {
            return response()->json(['success' => false, 'message' => 'Jawaban tidak ditemukan'], 404);
        }

        $jawaban->status = $status;
        if ($jawaban->save()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal Update Jawaban']);
        }
    }
}
