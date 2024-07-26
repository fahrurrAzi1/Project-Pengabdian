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
                        <div class="col-md-4 mb-2">
                            <div class="card">
                                <div class="card-header">{{ __('Profil Guru') }}</div>
                                <div class="card-body">
                                    <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <form action="{{ route('guru.store') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="content">Input Soal</label>
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-8 mt-2 mb-3 ml-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2>Bank Soal</h2>
                                </div>
                                <div class="card-body">
                                    @foreach($contents as $index => $content)
                                    <div class="content">
                                        <p><strong>Soal {{ $index + 1 }}:</strong></p>
                                        <div>{!! $content->body !!}</div>
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal" data-content-id="{{ $content->id }}" data-content-body="{{ $content->body }}">Edit</button>
                                        <form action="{{ route('guru.destroy', $content->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6  mb-3 ml-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2>Jawaban Siswa</h2>
                                </div>
                                <div class="card-body">
                                    @foreach($contents->pluck('jawabans')->flatten()->groupBy('user.id') 
                                    as $userId => $userJawabans)
                                    @php
                                        $firstJawaban = $userJawabans->first();
                                        $studentName = $firstJawaban && $firstJawaban->user ? $firstJawaban->user->name : '-';
                                    @endphp
                                        <button type="button" class="btn btn-info btn-sm mb-2" data-toggle="modal" 
                                        data-target="#answerModal" data-student-name="{{ $studentName }}" 
                                        data-answers='@json($userJawabans)'>
                                            Nama Siswa: {{ $studentName }}
                                        </button>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal edit konten -->

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Content</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="edit-form" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit-content">Content</label>
                            <textarea name="content" id="edit-content" class="form-control"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- modal jawaban -->
    <div class="modal fade" id="answerModal" tabindex="-1" aria-labelledby="answerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="answerModalLabel">Jawaban Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Siswa:</strong> <span id="modal-student-name"></span></p>
                    <p><strong>Jawaban:</strong></p>
                    <div id="modal-answers"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Skrip jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Skrip CKEDITOR -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <!--Skrip Jquery -->
        
    <!--Skrip Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

    
    <!--Skrip Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // fungsi memanggil edit pertanyaan
        $('#editModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var contentId = button.data('content-id');
            var contentBody = button.data('content-body');

            var modal = $(this);
            modal.find('.modal-body #edit-content').val(contentBody);
            modal.find('.modal-body #edit-form').attr('action', '/guru/' + contentId);

            // kode untuk edit content
            ClassicEditor
                .create(document.querySelector('#edit-content')).then(editor => {
                    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                        return new MyUploadAdapter(loader);
                    };
                })
                .catch(error => {
                    console.error(error);
                });
        });

        // kode pemanggil CKEDITOR
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return new MyUploadAdapter(loader);
                };
            })
            .catch(error => {
                console.error(error);
            });

        // fungsi memanggil jawaban siswa
        $('#answerModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var studentName = button.data('student-name');
            var answers = button.data('answers');

            var modal = $(this);
            modal.find('#modal-student-name').text(studentName);
            var answersContainer = modal.find('#modal-answers');
            answersContainer.empty();

            answers.forEach((answer, index) => {
                var statusClass = '';
                var disabledAttr = '';
                if (answer.status === 'Benar' || answer.status === 'Salah') {
                    statusClass = 'btn-secondary';
                    disabledAttr = 'disabled';
                }

                var answerHtml = `
                    <div class="mb-2">
                        <p><strong>Soal ${answer.content_id}:</strong></p>
                        <p>${answer.answer}</p>
                        <button class="btn btn-success btn-sm mark-answer ${statusClass}" data-answer-id="${answer.id}" data-status="Benar" ${disabledAttr}>Benar</button>
                        <button class="btn btn-danger btn-sm mark-answer ${statusClass}" data-answer-id="${answer.id}" data-status="Salah" ${disabledAttr}>Salah</button>
                    </div>
                `;
                answersContainer.append(answerHtml);
            });
        });

        // menandai jawaban melalui API
        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('mark-answer')) {
                var button = event.target;
                var answerId = button.dataset.answerId;
                var status = button.dataset.status;

                console.log('Sending request to mark answer:', { answerId, status });

            fetch(`/guru/mark-answer/${answerId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                    body: JSON.stringify({ status: status })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.text();
                })
                .then(text => {
                    console.log('Raw response text:', text);
                    try {
                        return JSON.parse(text);
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        throw new Error('Failed to parse JSON');
                    }
                })
                .then(data => {
                    console.log('Response data:', data);
                    if (data.success) {
                        button.closest('.mb-2').querySelectorAll('.mark-answer').forEach(btn => {
                            btn.classList.remove('btn-success', 'btn-danger');
                            btn.classList.add('btn-secondary');
                            btn.disabled = true;
                        });
                        alert(`Jawaban ${status}`);
                    } else {
                        alert('Failed to update answer status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                });
            }
        });

        class MyUploadAdapter {
            constructor(loader) {
                this.loader = loader;
                this.url = '{{ route('ckeditor.upload') }}';
            }

            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject, file);
                    this._sendRequest(file);
                }));
            }

            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open('POST', this.url, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.responseType = 'json';
            }

            _initListeners(resolve, reject, file) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `File tidak bisa di upload: ${file.name}.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    resolve({
                        default: response.url
                    });
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            _sendRequest(file) {
                const data = new FormData();
                data.append('upload', file);

                this.xhr.send(data);
            }
    }
    </script>
</x-app-layout>