@extends('landing.layouts.app')
@section('title', 'Jelajahi Berdasarkan Fakultas')

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-emerald-700 mb-8">Jelajahi Dokumen Berdasarkan Fakultas</h1>
        <div class="grid md:grid-cols-3 gap-6">
            @foreach($faculties as $faculty)
                <a href="{{ route('faculty.documents', $faculty->id) }}"
                   class="block bg-white p-6 rounded-lg shadow hover:shadow-lg transition duration-200">
                    <h3 class="text-xl font-semibold text-gray-800">{{ $faculty->name }}</h3>
                    <p class="text-gray-600 text-sm mt-2">{{ $faculty->documents_count }} dokumen tersedia</p>
                </a>
            @endforeach
        </div>
    </main>
@endsection
