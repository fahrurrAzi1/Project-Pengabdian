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
                                    <label for="content">Content</label>
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-8 mt-2 mb-3 ml-12">
                            <div class="card">
                                <div class="card-header">
                                    <h2>Konten Tersimpan</h2>
                                </div>
                                <div class="card-body">
                                    @foreach($contents as $content)
                                    <div class="content">
                                        {!! $content->body !!}
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

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
</x-app-layout>