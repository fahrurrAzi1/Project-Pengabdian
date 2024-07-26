<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Siswa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="container mt-3">
                    <div class="row">
                        <!-- Daftar guru pemberi pertanyaan -->
                        <div class="col-md-12 mb-12">
                            <h3>List Soal dari Guru</h3>
                            <form action="{{ route('siswa.show_questions') }}" method="POST" class="mt-2">
                                @csrf
                                @foreach ($teachers as $teacher)
                                    <button type="submit" name="teacher_id" value="{{ $teacher->id }}" 
                                        class="btn btn-primary btn-sm mb-2">{{ $teacher->name }}</button>
                                @endforeach
                            </form>
                        </div>
                        <!-- List Pertanyaan -->
                        @if (@isset($currentQuestion))
                            <div class="col-md-12 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Soal dari {{ $teacherName }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="question mb-2">
                                            <p><strong>Soal {{ $currentQuestionIndex + 1 }}:</strong></p>
                                            <div>{!! $currentQuestion->body !!}</div>
                                        </div>
                                        <form action="{{ route('siswa.submit_jawaban', $currentQuestion->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="jawaban">Jawaban:</label>
                                                <textarea name="jawaban" id="jawaban" class="form-control"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-success mt-2">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mb-2 text-center w-100">Pilih guru untuk melihat soal.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>