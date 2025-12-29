@extends('layout')
@section('content')

@if(Auth::check() && Auth::user()->role == 'admin')
<div class="bg-white p-6 mb-6 rounded shadow border-l-4 border-red-500 flex justify-between items-start">
    <div>
        <h3 class="font-bold text-lg mb-2">Panel Admin</h3>
        <p class="text-sm text-gray-600"></p>
    </div>

    <form action="{{ route('product.store') }}" method="POST" class="bg-gray-50 p-4 rounded border">
        @csrf
        <h4 class="font-bold text-sm mb-2">+ Tambah Menu Baru</h4>
        <div class="flex gap-2">
            <input type="text" name="name" placeholder="Nama Menu" class="border p-2 rounded text-sm w-48" required>
            <input type="number" name="price" placeholder="Harga" class="border p-2 rounded text-sm w-32" required>
            <button class="bg-red-500 text-white px-4 py-2 rounded text-sm font-bold hover:bg-red-600">Simpan</button>
        </div>
    </form>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="{{ (Auth::check() && Auth::user()->role == 'admin') ? 'col-span-3' : 'col-span-2' }}">
        <h2 class="text-xl font-bold mb-4">📋 Menu Kopi</h2>
        <div class="grid grid-cols-2 gap-4">
            @foreach($products as $product)
            <div class="bg-white p-4 rounded shadow">
                @if(Auth::check() && Auth::user()->role == 'admin')
                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="text-sm">
                    @csrf @method('PUT')
                    
                    @if($product->image)
                        <div class="mb-2 text-center">
                            <img src="{{ asset('storage/' . $product->image) }}" class="h-16 w-16 object-cover rounded mx-auto border">
                            <p class="text-[10px] text-gray-500">Gambar saat ini</p>
                        </div>
                    @endif

                    <label class="block text-xs text-gray-500 mb-1">Nama Menu:</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="font-bold w-full mb-2 border rounded p-1">
                    
                    <label class="block text-xs text-gray-500 mb-1">Harga:</label>
                    <input type="number" name="price" value="{{ $product->price }}" class="border p-1 w-full mb-2 rounded">
                    
                    <label class="block text-xs text-gray-500 mb-1">Ganti Foto:</label>
                    <input type="file" name="image" class="w-full text-xs border rounded p-1 mb-2 bg-gray-50">

                    <label class="flex items-center gap-2 text-xs mb-3 bg-gray-100 p-1 rounded">
                        <input type="checkbox" name="is_available" {{ $product->is_available ? 'checked' : '' }}> 
                        Status Tersedia?
                    </label>
                    
                    <button class="bg-blue-600 text-white px-3 py-1.5 rounded w-full font-bold hover:bg-blue-700 transition">
                        💾 Simpan Perubahan
                    </button>
                </form>
                
                @else
                    <h3 class="font-bold text-lg">{{ $product->name }}</h3>
                    <p class="text-gray-600">Rp {{ number_format($product->price) }}</p>
                    <p class="text-sm mb-2 {{ $product->is_available ? 'text-green-500' : 'text-red-500' }}">
                        {{ $product->is_available ? 'Ready' : 'Habis' }}
                    </p>
                    
                    @if($product->is_available)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button class="bg-amber-500 text-white px-4 py-2 rounded w-full">Pesan</button>
                    </form>
                    @endif
                @endif
            </div>
            @endforeach
        </div>
    </div>

   @if(!Auth::check() || Auth::user()->role == 'customer') 
    <div class="col-span-1">
        <div class="bg-white p-4 rounded shadow h-fit sticky top-4">
            <h2 class="text-xl font-bold mb-4">🛒 Keranjang</h2>
            
            @auth
                @if($carts->count() > 0)
                    @foreach($carts as $cart)
                    <div class="flex justify-between items-center border-b py-2 gap-2 text-sm">
                        <div class="flex-1">
                            <div class="font-bold">{{ $cart->product->name }}</div>
                            <div class="text-xs text-gray-500">
                                Rp {{ number_format($cart->product->price) }} x {{ $cart->quantity }}
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-1">
                            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="type" value="minus">
                                <button class="bg-gray-200 w-5 h-5 rounded hover:bg-gray-300">-</button>
                            </form>
                            
                            <span class="font-bold w-4 text-center">{{ $cart->quantity }}</span>
                            
                            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                @csrf @method('PATCH')
                                <input type="hidden" name="type" value="plus">
                                <button class="bg-gray-200 w-5 h-5 rounded hover:bg-gray-300">+</button>
                            </form>
                        </div>
                        
                        <form action="{{ route('cart.delete', $cart->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700">🗑️</button>
                        </form>
                    </div>
                    @endforeach

                    <div class="mt-4 font-bold text-right text-lg border-t pt-2">
                        Total: Rp {{ number_format($carts->sum(fn($c) => $c->product->price * $c->quantity)) }}
                    </div>

                    <button onclick="document.getElementById('payment-modal').classList.remove('hidden')" 
                            class="bg-green-600 text-white w-full py-3 rounded font-bold mt-4 hover:bg-green-700 transition shadow-lg">
                        Bayar Sekarang 💸
                    </button>

                    <div id="payment-modal" class="fixed inset-0 bg-black bg-opacity-70 hidden z-50 flex justify-center items-center p-4">
                        <div class="bg-white rounded-lg shadow-xl max-w-sm w-full p-6 text-center relative animate-bounce-in">
                            
                            <h3 class="text-xl font-bold mb-2 text-gray-800">Scan QRIS</h3>
                            <p class="text-sm text-gray-500 mb-4">Silakan scan kode di bawah untuk membayar.</p>
                            
                            <div class="bg-gray-100 p-4 rounded-lg inline-block mb-4 border-2 border-dashed border-gray-300">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=PembayaranAlumniCoffee" 
                                     alt="QR Code Pembayaran" 
                                     class="w-48 h-48 mx-auto">
                            </div>

                            <p class="font-bold text-amber-700 text-lg mb-6">
                                Total: Rp {{ number_format($carts->sum(fn($c) => $c->product->price * $c->quantity)) }}
                            </p>

                            <div class="space-y-3">
                                <form action="{{ route('checkout') }}" method="POST">
                                    @csrf
                                    <button class="bg-green-600 text-white w-full py-2 rounded font-bold hover:bg-green-700 shadow transition">
                                        ✅ Saya Sudah Bayar
                                    </button>
                                </form>

                                <button onclick="document.getElementById('payment-modal').classList.add('hidden')" 
                                        class="text-gray-500 text-sm hover:text-red-500 font-bold underline">
                                    Batalkan
                                </button>
                            </div>

                        </div>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">Keranjang masih kosong.</p>
                @endif
            @else
                <p class="text-gray-500 mt-2">Silakan <a href="/login" class="text-amber-600 underline font-bold">Login</a> untuk memesan.</p>
            @endauth
        </div>
    </div>
    @endif

</div> @endsection