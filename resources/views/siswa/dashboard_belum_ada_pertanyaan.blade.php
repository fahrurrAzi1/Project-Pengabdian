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
                        <div class="col-md-12">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <h2>Halaman Awal</h2>
                                </div>
                                <div class="card-body">
                                    <p>Belum ada soal dari guru.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
