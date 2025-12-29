<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Coffee</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        <aside class="w-64 bg-amber-900 text-white flex flex-col shadow-xl">
            
            <div class="h-16 flex items-center justify-center border-b border-amber-800 bg-amber-950">
                <h1 class="text-xl font-bold tracking-wider">
                    <i class="fa-solid fa-mug-hot mr-2"></i>Alumni Coffee
                </h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                
                @auth
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-amber-700 text-white' : 'hover:bg-amber-800 text-amber-100' }}">
                        <i class="fa-solid fa-book-open w-6"></i>
                        <span class="font-medium">Menu Kopi</span>
                    </a>

                    @if(Auth::user()->role == 'customer')
                        
                        <a href="{{ route('history') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('history') ? 'bg-amber-700 text-white' : 'hover:bg-amber-800 text-amber-100' }}">
                            <i class="fa-solid fa-clock-rotate-left w-6"></i>
                            <span class="font-medium">Riwayat</span>
                        </a>

                        <a href="{{ route('menu.gallery') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('menu.gallery') ? 'bg-amber-700 text-white' : 'hover:bg-amber-800 text-amber-100' }}">
                            <i class="fa-solid fa-images w-6"></i>
                            <span class="font-medium">Galeri Menu</span>
                        </a>

                    @endif

                    @if(Auth::user()->role == 'admin')
                        <div class="pt-4 pb-2">
                            <p class="text-xs uppercase text-amber-400 font-bold px-4">Admin Area</p>
                        </div>
                        
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-amber-700 text-white' : 'hover:bg-amber-800 text-amber-100' }}">
                            <i class="fa-solid fa-chart-line w-6"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>

                        <a href="{{ route('admin.orders') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('admin.orders') ? 'bg-amber-700 text-white' : 'hover:bg-amber-800 text-amber-100' }}">
                            <i class="fa-solid fa-clipboard-list w-6"></i>
                            <span class="font-medium">Kelola Pesanan</span>
                        </a>
                    @endif
                @else
                    <a href="/login" class="flex items-center px-4 py-3 rounded-lg hover:bg-amber-800 text-amber-100">
                        <i class="fa-solid fa-right-to-bracket w-6"></i> Login
                    </a>
                    <a href="/register" class="flex items-center px-4 py-3 rounded-lg hover:bg-amber-800 text-amber-100">
                        <i class="fa-solid fa-user-plus w-6"></i> Daftar
                    </a>
                @endauth

            </nav>

            @auth
            <div class="p-4 border-t border-amber-800 bg-amber-950">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-amber-700 flex items-center justify-center text-lg font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold truncate w-32">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-amber-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf 
                    <button class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded text-sm font-bold transition">
                        Logout
                    </button>
                </form>
            </div>
            @endauth

        </aside>

        <main class="flex-1 overflow-y-auto bg-gray-100">
            <header class="bg-white shadow p-4 flex justify-between md:hidden">
                <span class="font-bold text-amber-900">Alumni Coffee</span>
                <span class="text-xs text-gray-500">Mobile View</span>
            </header>

            <div class="p-8">
                @yield('content')
            </div>
        </main>

    </div>

</body>
</html>