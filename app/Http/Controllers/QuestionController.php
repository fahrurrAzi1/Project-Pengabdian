<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Question;

class QuestionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pertanyaan.*' => 'required|string', 
            'image' => 'nullable|image|max:2048', 
        ]);

        try {
            foreach ($validatedData['pertanyaan'] as $pertanyaan) {
                $question = new Question;
                $question->pertanyaan = $pertanyaan;
                $question->image = $request->file('image')->store('public/questions');
                $question->save();
            }

            return redirect()->route('questions.index') 
                ->with('success', 'Soal berhasil disimpan!');

        } catch (\Exception $e) {
            return redirect()->back() 
                ->with('error', 'Terjadi kesalahan saat menyimpan soal. Silahkan coba lagi.');
        }
    }
}
