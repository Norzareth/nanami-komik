<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nanami Komik</title>
    @vite('resources/css/app.css') 
</head>
<body class="bg-gray-900 text-white font-sans">

    <nav class="bg-black p-4 flex justify-between items-center">
    <div class="flex items-center space-x-6">
        <a href="/" class="text-teal-400 text-2xl font-bold tracking-widest">Nanami</a>
        <a href="/browse" class="text-gray-300 hover:text-white text-sm">BROWSE</a>
        <a href="/library" class="text-gray-300 hover:text-white text-sm">MY LIBRARY</a>
    </div>
    <div>
        <a href="/login" class="bg-teal-500 hover:bg-teal-400 text-black px-4 py-2 font-bold rounded">LOGIN</a>
    </div>
</nav>

    <div class="container mx-auto p-4">
        @yield('content')
    </div>

</body>
</html>