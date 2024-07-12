<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Guru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- <div class="p-6 text-gray-900">
                    {{ __("You're logged in as Guru!") }}
                </div> --}}
                <div class="container mt-3">
                    <div class="row">
                        <!-- Profil Guru -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">{{ __('Profil Guru') }}</div>
                                <div class="card-body">
                                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 mb-8">
                            <div class="card">
                                <div class="card-header">{{ __('Buat Soal') }}</div>
                                <div class="card-body">
                                    <form id="form-soal" action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div id="soal-container">
                                            <div class="form-group d-flex align-items-center" id="question-1">
                                                <label for="pertanyaan_1" class="sr-only">Pertanyaan 1:</label>
                                                <textarea class="form-control me-2" id="pertanyaan_1" name="pertanyaan[]" placeholder="Pertanyaan 1" required></textarea>
                                                <button type="button" class="btn btn-danger ml-2" onclick="removeQuestion(this)">Hapus</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="addQuestion()">Tambah Pertanyaan</button>
                                        <button type="submit" class="btn btn-success">Simpan Soal</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.ckeditor.com/ckeditor5/35.3.1/classic/ckeditor.js"></script>

    <script>
        function addQuestion() {
            let soalContainer = document.getElementById('soal-container');
            let questionCount = soalContainer.querySelectorAll('.form-group').length;
            let newQuestion = document.createElement('div');
            newQuestion.classList.add('form-group', 'd-flex', 'align-items-center');
            newQuestion.innerHTML = `
                <label for="pertanyaan_${questionCount + 1}" class="sr-only">Pertanyaan ${questionCount + 1}:</label>
                <textarea class="form-control me-2" id="pertanyaan_${questionCount + 1}" name="pertanyaan[]" placeholder="Pertanyaan ${questionCount + 1}" required></textarea>
                <button type="button" class="btn btn-danger ml-2" onclick="removeQuestion(this)">Hapus</button>
            `;
            soalContainer.appendChild(newQuestion);

            ClassicEditor
                .create( document.getElementById(`pertanyaan_${questionCount + 1}`) )
                .catch( error => {
                    console.error( error );
                } );
        }

        function removeQuestion(button) {
            button.parentNode.remove();
        }

        ClassicEditor
            .create( document.querySelector( '#pertanyaan_1' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>

</x-app-layout>