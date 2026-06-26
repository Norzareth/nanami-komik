@extends('base.base')

@section('content')
    <h2 class="text-3xl font-bold mb-6 mt-8">My Library</h2>

    @if($bookmarks->isEmpty())
        <div class="bg-gray-800 p-8 text-center rounded-lg">
            <p class="text-gray-400">Kamu belum menambahkan komik ke daftar favoritmu.</p>
            <a href="/browse" class="inline-block mt-4 bg-teal-500 hover:bg-teal-400 text-black font-bold py-2 px-4 rounded">
                Cari Komik
            </a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach($bookmarks as $bookmark)
                @if($bookmark->komik)
                    <a href="{{ route('komik.show', $bookmark->komik->id_komik) }}" class="block bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-200">
                        <img src="{{ $bookmark->komik->url_cover ?? 'https://via.placeholder.com/300x420' }}" alt="Cover" class="w-full h-52 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-white truncate">{{ $bookmark->komik->nama_komik }}</h3>
                            <p class="text-yellow-400 text-sm">★ {{ number_format($bookmark->komik->rating_rata, 1) }}</p>
                            <p class="text-slate-400 text-xs">❤ {{ $bookmark->komik->likes_count ?? $bookmark->komik->likes->count() }} likes</p>
                        </div>
                    </a>
                @endif
            @endforeach
        </div>
    @endif
@endsection
