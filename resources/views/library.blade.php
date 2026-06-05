@extends('base.base')

@section('content')
    <h2 class="text-3xl font-bold mb-6 mt-8">My Library</h2>
    
    <div class="bg-gray-800 p-8 text-center rounded-lg">
        <p class="text-gray-400">Kamu belum menambahkan komik ke daftar favoritmu.</p>
        <a href="/browse" class="inline-block mt-4 bg-teal-500 hover:bg-teal-400 text-black font-bold py-2 px-4 rounded">
            Cari Komik
        </a>
    </div>
@endsection
