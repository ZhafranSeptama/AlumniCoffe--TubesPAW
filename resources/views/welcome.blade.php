<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Alumni Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-bg {
            background-image: url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1951&q=80');
            background-size: cover;
            background-position: center;
        }
        .overlay { background-color: rgba(0, 0, 0, 0.6); }
    </style>
</head>
<body class="hero-bg h-screen w-full relative">

    <div class="overlay absolute inset-0 flex flex-col justify-center items-center text-center text-white px-4">
        
        <div class="mb-6 animate-bounce">
            <span class="text-6xl">☕</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl font-bold mb-4 tracking-wide">
            ALUMNI COFFEE
        </h1>
        
        <p class="text-lg md:text-xl mb-8 max-w-lg text-gray-200">
            Nikmati cita rasa kopi terbaik bersama kenangan manis masa lalu. Pesan sekarang, santai kemudian.
        </p>

        <div class="space-y-4">
            @auth
                <p class="text-amber-300 font-bold mb-2">Halo, {{ Auth::user()->name }}!</p>
                <a href="{{ route('home') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-8 rounded-full text-lg transition transform hover:scale-105 shadow-lg">
                    Lanjut Pesan Kopi 🚀
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-block bg-white text-amber-900 font-bold py-3 px-8 rounded-full text-lg transition transform hover:scale-105 shadow-lg hover:bg-gray-100">
                    Login
                </a>
                
                <div class="mt-4">
                    <span class="text-sm text-gray-300">Belum punya akun?</span>
                    <a href="{{ route('register') }}" class="text-amber-400 font-bold hover:underline">Daftar disini</a>
                </div>
            @endauth
        </div>

    </div>

    <div class="absolute bottom-4 w-full text-center text-gray-400 text-xs">
        &copy; {{ date('Y') }} Alumni Coffee Project.
    </div>

</body>
</html>