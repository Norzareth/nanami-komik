@extends('base.base')

@section('content')
    <h2 class="text-xl font-bold mb-4">Recommended for You</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        
        @foreach($rekomendasi as $komik)
        <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
            <img src="{{ $komik->url_cover ?? 'https://via.placeholder.com/150x200' }}" alt="Cover" class="w-full h-48 object-cover">
            <div class="p-2">
                <p class="text-sm font-bold truncate">{{ $komik->nama_komik }}</p>
                <p class="text-xs text-teal-400">{{ $komik->status_pengerjaan }}</p>
            </div>
        </div>
        @endforeach

    </div>
@endsection