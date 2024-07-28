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
                        @if (!isset($currentQuestion))
                            <div class="col-md-12 mb-12" id="teacherList">
                                <h3>List Soal dari Guru</h3>
                                <form id="teacherForm" action="{{ route('siswa.show_questions') }}" method="POST" class="mt-2">
                                    @csrf
                                    @foreach ($teachers as $teacher)
                                        <!-- Kode Utama -->
                                        <button type="button" class="btn btn-primary btn-sm mb-2" onclick="confirmSelectTeacher({{ $teacher->id }}, 
                                        '{{ $teacher->name }}')">{{ $teacher->name }}</button>
                                    @endforeach
                                </form>
                            </div>
                        @endif
                        <!-- List Pertanyaan -->
                        @if (@isset($currentQuestion))
                            <div class="col-md-12 mt-2">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h3>Soal dari {{ $teacherName }}</h3>
                                        <button type="button" class="close float-right text-danger" onclick="confirmClose()" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
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

    <script>

        // fungsi swal fire untuk menutup kuis dari guru yang dipilih

        function confirmClose() 
        {
            Swal.fire({
                title:'Anda yakin ingin menutup?',
                text:'Anda akan kembali ke daftar pertanyaan guru',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: 'Ya, tutup',
                cancelButtonText: 'Batal',
            }).then((result)=> {
                if(result.isConfirmed) {
                    window.location.href="{{ route('siswa.dashboard') }}";
                }
            })
        }

        // fungsi untuk memanggil swal fire untuk melanjutkan ke kuis guru yang dipilih

        function confirmSelectTeacher(teacherId, teacherName) 
        {
            Swal.fire({
                title: `Anda memilih ${teacherName}`,
                text: "Anda yakin ingin melanjutkan",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    let form = document.getElementById('teacherForm');
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'teacher_id';
                    input.value = teacherId;
                    form.appendChild(input);
                    form.submit();    
                } else {
                    console.error('Form Tidak Di Akses');
                }
            })
        }

    </script>

</x-app-layout>


                                        <!-- Alternatif Code -->

                                        {{-- <button type="submit" name="teacher_id" value="{{ $teacher->id }}" 
                                        class="btn btn-primary btn-sm mb-2">{{ $teacher->name }}</button> --}}
