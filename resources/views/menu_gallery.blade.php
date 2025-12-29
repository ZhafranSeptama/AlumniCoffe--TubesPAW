@extends('layout')

@section('content')
<div class="max-w-7xl mx-auto mt-4">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">📸 Galeri Menu</h2>
            <p class="text-gray-500 mt-2">Lihat koleksi lengkap kopi terbaik kami.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            
            <div class="relative h-64 w-full overflow-hidden">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                         alt="{{ $product->name }}">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                        <i class="fa-solid fa-mug-hot text-4xl"></i>
                    </div>
                @endif

                <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-bold text-amber-800 shadow">
                    Rp {{ number_format($product->price) }}
                </div>

                @if(!$product->is_available)
                <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                    <span class="text-white font-bold border-2 border-white px-4 py-1 rounded uppercase tracking-widest">HABIS</span>
                </div>
                @endif
            </div>

            <div class="p-5 text-center">
                <h3 class="font-bold text-lg text-gray-800 mb-1">{{ $product->name }}</h3>
                <div class="w-10 h-1 bg-amber-500 mx-auto rounded mb-3"></div>
                
                @if($product->is_available)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="text-sm bg-gray-800 text-white px-6 py-2 rounded-full hover:bg-amber-600 transition w-full">
                            + Masuk Keranjang
                        </button>
                    </form>
                @else
                    <button disabled class="text-sm bg-gray-300 text-gray-500 px-6 py-2 rounded-full cursor-not-allowed w-full">
                        Tidak Tersedia
                    </button>
                @endif
            </div>

        </div>
        @endforeach
    </div>
</div>
@endsection