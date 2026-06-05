@extends('base.base')

@section('content')
<div class="flex justify-center mt-20">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold text-center mb-6 text-teal-400">Welcome Back</h2>
        
        <form action="/login" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-300 mb-2">Email Address</label>
                <input type="email" name="email_user" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-teal-400 focus:outline-none" required>
            </div>
            
            <div class="mb-6">
                <label class="block text-gray-300 mb-2">Password</label>
                <input type="password" name="password" class="w-full p-2 rounded bg-gray-700 text-white border border-gray-600 focus:border-teal-400 focus:outline-none" required>
            </div>
            
            <button type="submit" class="w-full bg-teal-500 hover:bg-teal-400 text-black font-bold py-2 px-4 rounded">
                Login
            </button>
        </form>
    </div>
</div>
@endsection