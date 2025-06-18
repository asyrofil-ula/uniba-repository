@extends('landing.layouts.app')
@section('title', 'Jelajahi Berdasarkan Tahun')

@section('content')
    <main class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-emerald-700 mb-8">Jelajahi Dokumen Berdasarkan Tahun Terbit</h1>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($years as $year)
                <a href="{{ route('year.documents', $year) }}"
                   class="block bg-white p-4 rounded-lg text-center shadow hover:shadow-lg transition">
                    <span class="text-lg font-semibold text-gray-800">{{ $year }}</span>
                </a>
            @endforeach
        </div>
    </main>
@endsection
