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
                                    <!-- Tambahkan informasi profil lainnya di sini -->
                                </div>
                            </div>
                        </div>
                        <!-- Buat Soal -->
                        <div class="col-md-8 mb-8">
                            <div class="card">
                                <div class="card-header">{{ __('Buat Soal') }}</div>
                                <div class="card-body">
                                    <form id="form-soal">
                                        <div id="soal-container">
                                            <div class="form-group d-flex align-items-center">
                                                <label for="pertanyaan_1" class="sr-only">Pertanyaan 1:</label>
                                                <input type="text" class="form-control me-2" id="pertanyaan_1" name="pertanyaan[]" placeholder="Pertanyaan 1">
                                                <button type="button" class="btn btn-danger" onclick="removeQuestion(this)">Hapus</button>
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
 
    <script>
        let questionCount = 1;
    
        function addQuestion() {
            questionCount++;
            const questionHTML = `
                <div class="form-group d-flex align-items-center mt-2">
                    <label for="pertanyaan_${questionCount}" class="sr-only">Pertanyaan ${questionCount}:</label>
                    <input type="text" class="form-control me-2" id="pertanyaan_${questionCount}" name="pertanyaan[]" placeholder="Pertanyaan ${questionCount}">
                    <button type="button" class="btn btn-danger" onclick="removeQuestion(this)">Hapus</button>
                </div>
            `;
            document.getElementById('soal-container').insertAdjacentHTML('beforeend', questionHTML);
            updateQuestionLabels();
        }
    
        function removeQuestion(button) {
            button.closest('.form-group').remove();
            updateQuestionLabels();
        }
    
        function updateQuestionLabels() {
            const questions = document.querySelectorAll('#soal-container .form-group');
            questionCount = questions.length;
            questions.forEach((question, index) => {
                const label = question.querySelector('label');
                const input = question.querySelector('input');
                label.setAttribute('for', `pertanyaan_${index + 1}`);
                label.textContent = `Pertanyaan ${index + 1}:`;
                input.setAttribute('id', `pertanyaan_${index + 1}`);
                input.setAttribute('placeholder', `Pertanyaan ${index + 1}`);
            });
        }
    </script>

</x-app-layout>