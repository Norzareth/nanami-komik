@extends('base.base')

@section('content')
    <div class="page-container">
        <h2 class="text-2xl md:text-3xl font-bold mb-5">Recommended for You</h2>
        <div class="comic-grid">
            @foreach($rekomendasi as $komik)
                <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-200">
                    <img src="{{ $komik->url_cover ?? 'https://via.placeholder.com/150x200' }}" alt="Cover" class="w-full h-44 sm:h-52 object-cover">
                    <div class="p-3">
                        <p class="text-sm font-semibold truncate">{{ $komik->nama_komik }}</p>
                        <p class="text-xs text-teal-400 mt-1">{{ $komik->status_pengerjaan }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mb-10 mt-12">
            <h2 class="text-xl font-bold text-teal-400 mb-4">⭐ Top Comics</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                @foreach($topKomik as $top)
                    <a href="{{ route('komik.show', $top->id_komik) }}"
                       class="bg-gray-800 rounded-xl overflow-hidden hover:ring-2 hover:ring-teal-400 transition duration-200">
                        <img src="{{ $top->url_cover ?? 'https://via.placeholder.com/150x200' }}"
                             alt="Cover" class="w-full h-44 object-cover">
                        <div class="p-3 space-y-1">
                            <p class="text-sm font-semibold text-white truncate">{{ $top->nama_komik }}</p>
                            <p class="text-yellow-400 text-xs">★ {{ number_format($top->rating_rata, 1) }}</p>
                            <p class="text-slate-400 text-xs">❤ {{ $top->likes_count }} likes</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
