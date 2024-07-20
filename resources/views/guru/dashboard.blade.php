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
                                    @foreach($contents as $content)
                                    <div class="content">
                                        {!! $content->body !!}
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
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <!-- CKEDITOR 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        
    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>

    
    <!-- Bootstrap JS -->
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
        });

        // kode pemanggil CKEDITOR
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>