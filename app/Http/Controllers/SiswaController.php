<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Jawaban;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SiswaController extends Controller
{
    public function index()
    {
        // menampilkan semua konten
        $contents = Content::all();

        // memeriksa jika belum ada jawaban
        if($contents->isEmpty()){
            return view('siswa.dashboard_belum_ada_pertanyaan');
        }

        // menampilkan list pertanyaan dari guru
        $teachers = User::where('role', 'guru')->get();
        $currentQuestionIndex = Session::get('current_question_index', 0);
        $currentQuestion = null;
        $teacherName = null;

        // mengembalikan setelah menampilkan pertanyaan
        return view('siswa.dashboard', compact('teachers', 'currentQuestion', 'currentQuestionIndex', 'teacherName'));
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

    public function showQuestions(Request $request)
    {
        $teacherId = $request->input('teacher_id');
        $teacher = User::find($teacherId);
        $questions = Content::where('teacher_id', $teacherId)->get();
        
        if ($questions->isEmpty()) {
            session()->flash('Kosong', 'Tidak ada pertanyaan yang diajukan guru.');
    
            return view('siswa.dashboard', [
                'teachers' => User::where('role', 'guru')->get(),
                'questions' => [],
                'teacherName' => $teacher->name,
                'currentQuestionIndex' => 0,
                'currentQuestion' => null
            ]);
        }

        $currentQuestionIndex = 0;
        $currentQuestion = $questions[$currentQuestionIndex];

        return view('siswa.dashboard', [
            'teachers' => User::where('role', 'guru')->get(),
            'questions' => $questions,
            'teacherName' => $teacher->name,
            'currentQuestionIndex' => $currentQuestionIndex,
            'currentQuestion' => $currentQuestion
        ]);
    }
}
