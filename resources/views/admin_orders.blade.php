@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Kelola Pesanan Masuk</h2>
        <a href="{{ route('home') }}" class="text-amber-600 underline text-sm">Kembali ke Menu</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <div class="bg-white p-4 rounded shadow mb-4">
        <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            
            <div class="w-full md:w-1/4">
                <label class="text-xs font-bold text-gray-600 uppercase mb-1 block">Filter Status</label>
                <select name="status" class="w-full border p-2 rounded text-sm focus:outline-none focus:border-amber-500">
                    <option value="">-- Semua Status --</option>
                    <option value="Sudah Bayar" {{ request('status') == 'Sudah Bayar' ? 'selected' : '' }}>Sudah Bayar</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="w-full md:w-1/4">
                <label class="text-xs font-bold text-gray-600 uppercase mb-1 block">Urutkan</label>
                <select name="sort" class="w-full border p-2 rounded text-sm focus:outline-none focus:border-amber-500">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Tanggal Terbaru</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Tanggal Terlama</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded text-sm font-bold hover:bg-amber-700 transition">
                    <i class="fa-solid fa-filter"></i> Terapkan
                </button>
                
                @if(request()->has('status') || request()->has('sort'))
                <a href="{{ route('admin.orders') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded text-sm font-bold hover:bg-gray-300 transition">
                    Reset
                </a>
                @endif
            </div>

        </form>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
    ...
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="p-4 text-sm">ID</th>
                    <th class="p-4 text-sm">Nama Pelanggan</th>
                    <th class="p-4 text-sm">Tanggal</th>
                    <th class="p-4 text-sm">Total</th>
                    <th class="p-4 text-sm">Status</th>
                    <th class="p-4 text-sm">Detail</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 text-gray-500">#{{ $order->id }}</td>
                    <td class="p-4 font-bold text-gray-800">{{ $order->user->name }}</td>
                    <td class="p-4 text-gray-600 text-sm">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="p-4 font-bold text-amber-700">
                        Rp {{ number_format($order->total_price) }}
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <button onclick="document.getElementById('detail-{{ $order->id }}').classList.remove('hidden')" 
                                class="bg-blue-600 text-white px-3 py-1 rounded text-xs hover:bg-blue-700 transition">
                            👁️ Lihat Item
                        </button>
                    </td>
                </tr>

                <div id="detail-{{ $order->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex justify-center items-center">
                    <div class="bg-white w-96 p-6 rounded shadow-lg relative">
                        <div class="flex justify-between items-center border-b pb-2 mb-4">
                            <h3 class="font-bold text-lg">Detail Order #{{ $order->id }}</h3>
                            <button onclick="document.getElementById('detail-{{ $order->id }}').classList.add('hidden')" class="text-gray-500 hover:text-red-500 font-bold">✕</button>
                        </div>
                        <div class="mb-4 text-sm bg-gray-50 p-3 rounded">
                            <p><strong>Pemesan:</strong> {{ $order->user->name }}</p>
                            <p><strong>Email:</strong> {{ $order->user->email }}</p>
                            <p><strong>Waktu:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="space-y-2 mb-4">
                            <p class="font-bold text-sm border-b pb-1">Item yang dibeli:</p>
                            @foreach($order->items as $item)
                            <div class="flex justify-between text-sm">
                                <span>{{ $item->product_name }} <span class="text-xs text-gray-500">(x{{ $item->quantity }})</span></span>
                                <span class="font-mono">Rp {{ number_format($item->product_price * $item->quantity) }}</span>
                            </div>
                            @endforeach
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t pt-2 text-amber-700">
                            <span>TOTAL</span>
                            <span>Rp {{ number_format($order->total_price) }}</span>
                        </div>
                        <button onclick="document.getElementById('detail-{{ $order->id }}').classList.add('hidden')" class="w-full bg-gray-800 text-white py-2 rounded mt-6 hover:bg-gray-900">
                            Tutup
                        </button>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="6" class="p-8 text-center text-gray-500">Belum ada pesanan masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection