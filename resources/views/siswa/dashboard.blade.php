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
                        <!-- List Pertanyaan -->
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2>Soal {{ $currentQuestionIndex + 1 }}:</h2>
                                </div>
                                <div class="card-body">
                                    <div class="content mb-4">
                                        <div>{!! $currentQuestion->body !!}</div>
                                        <form action="{{ route('siswa.submit_jawaban', $currentQuestion->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="jawaban-{{ $currentQuestion->id }}">Jawab: </label>
                                                <textarea name="jawaban" id="jawaban-{{ $currentQuestion->id }}" class="form-control" rows="2"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Submit Jawaban</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>