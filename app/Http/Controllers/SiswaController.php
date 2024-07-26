<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Jawaban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
    public function index()
    {
        // menampilkan konten pada soal
        $contents = Content::all();

        //memeriksa jika belum ada jawaban
        if($contents->isEmpty()){
            return view('siswa.dashboard_belum_ada_pertanyaan');
        }

        $currentQuestionIndex = Session::get('current_question_index', 0);

        if ($currentQuestionIndex >= $contents->count()) {
            return view('siswa.dashboard_selesai');
        }

        $currentQuestion = $contents[$currentQuestionIndex];
        return view('siswa.dashboard', compact('currentQuestion', 'currentQuestionIndex'));
    }

    // menangani jawaban user siswa
    public function submitJawaban(Request $request, $contentId)
    {
        $request->validate([
            'jawaban' => 'required',
        ]);

        $existingJawaban = Jawaban::where('content_id', $contentId)
                              ->where('user_id', auth()->user()->id)
                              ->first();
                              
        if ($existingJawaban) {
            $existingJawaban->delete();
        }

        $jawaban = new Jawaban();
        $jawaban->content_id = $contentId;
        $jawaban->user_id = auth()->user()->id;
        $jawaban->answer = $request->input('jawaban');
        $jawaban->save();

        $currentQuestionIndex = Session::get('current_question_index', 0);
        Session::put('current_question_index', $currentQuestionIndex + 1);

        if ($currentQuestionIndex + 1 >= Content::count()) {
            return redirect()->route('siswa.dashboard_selesai')->with('Sukses', 'Jawaban telah terkirim');
        }

        return redirect()->route('siswa.dashboard')->with('Sukses', 'Jawaban telah terkirim');
    }

    public function selesai()
    {
        return view('siswa.dashboard_selesai');
    }
}
