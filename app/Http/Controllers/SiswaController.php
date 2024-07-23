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

        $jawaban = new Jawaban();
        $jawaban->content_id = $contentId;
        $jawaban->user_id = auth()->user()->id;
        $jawaban->answer = $request->input('jawaban');
        $jawaban->save();

        $currentQuestionIndex = Session::get('current_question_index', 0);
        Session::put('current_question_index', $currentQuestionIndex + 1);

        return redirect()->route('siswa.dashboard')->with('Sukses', 'Jawaban telah terkirim');
    }

}
