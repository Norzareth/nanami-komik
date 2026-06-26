@extends('base.base')

@section('content')
<div class="page-container">

    <div class="mb-8">
        <h2 class="text-2xl md:text-3xl font-bold mb-4">Browse All Comics</h2>
        <form action="{{ route('browse') }}" method="GET" class="flex flex-col sm:flex-row items-stretch gap-3">
            <input
                type="text"
                name="search"
                value="{{ $search ?? '' }}"
                placeholder="Search comics..."
                class="w-full rounded-lg border border-slate-700 bg-slate-900 text-white px-4 py-3 focus:border-teal-400 focus:outline-none"
            >
            <button type="submit" class="rounded-lg bg-teal-500 px-5 py-3 text-black font-semibold hover:bg-teal-400 transition">
                Search
            </button>
        </form>
    </div>

    @if(isset($search) && $search !== '')
        <p class="mb-6 text-slate-400">Search results for "{{ $search }}"</p>
    @endif

    {{-- SEMUA KOMIK --}}
    <div class="comic-grid">
        @forelse($semuaKomik as $komik)
            <div class="bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-200">
                <img src="{{ $komik->url_cover ?? 'https://via.placeholder.com/150x200' }}"
                     alt="Cover" class="w-full h-44 sm:h-52 object-cover">
                <div class="p-3">
                    <a href="{{ route('komik.show', $komik->id_komik) }}"
                       class="text-sm font-semibold truncate text-white hover:text-teal-300">
                        {{ $komik->nama_komik }}
                    </a>
                    <div class="flex items-center justify-between mt-1">
                        <span class="text-yellow-400 text-xs">★ {{ number_format($komik->rating_rata, 1) }}</span>
                        <span class="text-slate-400 text-xs">❤ {{ $komik->likes_count }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-800 rounded-xl p-8 text-center">
                <p class="text-slate-400">Tidak ada komik yang cocok dengan pencarian kamu.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection