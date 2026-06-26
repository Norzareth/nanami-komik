@extends('base.base')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="grid gap-6 lg:grid-cols-[280px_1fr]">

        {{-- KOLOM KIRI: Cover + Like + Rating --}}
        <div class="space-y-4">
            <div class="bg-slate-900 p-4 rounded-xl border border-slate-700">
                <img src="{{ $komik->url_cover ?? 'https://via.placeholder.com/280x420' }}"
                     alt="Cover" class="w-full rounded-lg mb-4 object-cover">
                <div class="text-sm text-slate-400 mb-2">Release: {{ $komik->tanggal_rilis ?? 'Unknown' }}</div>
                <div class="text-sm text-slate-400 mb-4">Status: {{ $komik->status_pengerjaan ?? 'Unknown' }}</div>

                {{-- LIKE BUTTON --}}
                @auth
                    @php $sudahLike = $komik->likes->where('id_user', auth()->id())->count(); @endphp
                    <form action="{{ route('like.toggle') }}" method="POST" class="mb-3">
                        @csrf
                        <input type="hidden" name="id_komik" value="{{ $komik->id_komik }}">
                        <button type="submit"
                            class="w-full py-2 rounded font-semibold text-sm transition
                                {{ $sudahLike ? 'bg-teal-500 text-black' : 'bg-slate-700 text-white hover:bg-slate-600' }}">
                            ❤ {{ $komik->likes->count() }} {{ $sudahLike ? 'Liked' : 'Like' }}
                        </button>
                    </form>

                    <form action="{{ $isBookmarked ? route('bookmark.destroy', $bookmarkId) : route('bookmark.store') }}" method="POST">
                        @csrf
                        @if($isBookmarked)
                            @method('DELETE')
                        @endif
                        <input type="hidden" name="ID_Komik" value="{{ $komik->id_komik }}">
                        <button type="submit"
                            class="w-full py-2 rounded font-semibold text-sm transition
                                {{ $isBookmarked ? 'bg-slate-700 text-white hover:bg-slate-600' : 'bg-teal-500 text-black hover:bg-teal-400' }}">
                            {{ $isBookmarked ? 'Remove Bookmark' : 'Add Bookmark' }}
                        </button>
                    </form>
                @else
                    <div class="space-y-3">
                        <div class="w-full py-2 rounded text-center text-sm bg-slate-700 text-slate-400">
                            ❤ {{ $komik->likes->count() }} Likes
                        </div>
                        <div class="w-full py-2 rounded text-center text-sm bg-slate-700 text-slate-400">
                            <a href="{{ route('login') }}" class="text-teal-300 hover:underline">Login</a> untuk bookmark komik ini.
                        </div>
                    </div>
                @endauth

                {{-- RATING --}}
                <div class="mt-4">
                    <p class="text-slate-400 text-xs mb-1">
                        Rating: <span class="text-yellow-400 font-bold">{{ number_format($komik->rating_rata, 1) }} ★</span>
                        ({{ $komik->ratings->count() }} ulasan)
                    </p>

                    @auth
                        <form action="{{ route('rating.store') }}" method="POST" class="flex items-center gap-1">
                            @csrf
                            <input type="hidden" name="id_komik" value="{{ $komik->id_komik }}">
                            @php
                                $myRating = $komik->ratings->where('id_user', auth()->id())->first()?->nilai ?? 0;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="nilai" value="{{ $i }}" class="hidden"
                                        {{ $myRating == $i ? 'checked' : '' }}>
                                    <span class="text-xl {{ $myRating >= $i ? 'text-yellow-400' : 'text-slate-600' }} group-hover:text-yellow-300 transition">★</span>
                                </label>
                            @endfor
                            <button type="submit"
                                class="ml-2 bg-teal-500 hover:bg-teal-400 text-black px-2 py-1 rounded text-xs font-semibold">
                                OK
                            </button>
                        </form>
                    @else
                        <p class="text-slate-500 text-xs">
                            <a href="{{ route('login') }}" class="text-teal-400 hover:underline">Login</a> untuk memberi rating.
                        </p>
                    @endauth
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Info + Chapters + Komentar --}}
        <div class="space-y-6">

            {{-- JUDUL & SINOPSIS --}}
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-bold text-white">{{ $komik->nama_komik }}</h1>
                    <p class="text-slate-300 mt-3">{{ $komik->sinopsis_komik }}</p>
                </div>
                @auth
                    @if(auth()->user()->role_user === 1)
                        <a href="{{ route('admin.komik.edit', $komik->id_komik) }}"
                           class="inline-flex items-center justify-center rounded bg-teal-500 px-5 py-3 text-sm font-semibold text-black hover:bg-teal-400 whitespace-nowrap">
                            Add Chapter
                        </a>
                    @endif
                @endauth
            </div>

            {{-- CHAPTERS --}}
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-700">
                <h2 class="text-2xl font-semibold text-white mb-4">Chapters</h2>
                @if($komik->chapters->isEmpty())
                    <p class="text-slate-400">No chapters yet.</p>
                @else
                    <ul class="space-y-3">
                        @foreach($komik->chapters as $chapter)
                            <li class="p-4 rounded-lg bg-slate-800 border border-slate-700">
                                <a href="{{ route('komik.chapter.show', $chapter->id_chapter) }}"
                                   class="block text-white font-semibold hover:text-teal-300">
                                    {{ $chapter->judul_chapter }}
                                </a>
                                <p class="text-slate-400 text-sm mt-1">Chapter {{ $chapter->nomor_chapter }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- KOMENTAR --}}
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-700">
                <h2 class="text-2xl font-semibold text-white mb-4">Komentar</h2>

                @auth
                    @if(session('success'))
                        <div class="bg-teal-800 text-teal-200 text-sm px-4 py-2 rounded mb-3">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form action="{{ route('komentar.store') }}" method="POST" class="mb-5">
                        @csrf
                        <input type="hidden" name="id_komik" value="{{ $komik->id_komik }}">
                        <textarea name="isi" rows="3" placeholder="Tulis komentar kamu..."
                            class="w-full bg-slate-800 text-white rounded-lg p-3 text-sm border border-slate-600 focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
                        @error('isi')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        <button type="submit"
                            class="mt-2 bg-teal-500 hover:bg-teal-400 text-black px-4 py-2 rounded font-semibold text-sm">
                            Kirim
                        </button>
                    </form>
                @else
                    <p class="text-slate-400 text-sm mb-4">
                        <a href="{{ route('login') }}" class="text-teal-400 hover:underline">Login</a> untuk berkomentar.
                    </p>
                @endauth

                {{-- LIST KOMENTAR --}}
                @forelse($komik->komentar->sortByDesc('created_at') as $kom)
                    <div class="bg-slate-800 rounded-lg p-4 mb-3 border border-slate-700">
                        <p class="text-teal-400 text-sm font-semibold">
                            {{ $kom->user->nama_user ?? 'User' }}
                        </p>
                        <p class="text-slate-300 text-sm mt-1">{{ $kom->isi }}</p>
                        <p class="text-slate-500 text-xs mt-2">{{ $kom->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm">Belum ada komentar.</p>
                @endforelse
            </div>

        </div>
    </div>
</div>
@endsection