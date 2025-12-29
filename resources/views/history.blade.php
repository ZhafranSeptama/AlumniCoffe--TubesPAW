@extends('layout')

@section('content')
<div class="max-w-4xl mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📜 Riwayat Pesanan Saya</h2>
        <a href="{{ route('home') }}" class="text-amber-600 underline text-sm">Kembali ke Menu</a>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-4 text-sm font-semibold text-gray-600">Tanggal</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Total</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="p-4 text-gray-700 text-sm">
                        {{ $order->created_at->format('d M Y, H:i') }}
                    </td>
                    <td class="p-4 font-bold text-amber-700 text-sm">
                        Rp {{ number_format($order->total_price) }}
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <button onclick="document.getElementById('receipt-{{ $order->id }}').classList.remove('hidden')" 
                                class="bg-gray-800 text-white px-3 py-1 rounded text-xs hover:bg-gray-900 transition flex items-center gap-1">
                            📄 Lihat Struk
                        </button>
                    </td>
                </tr>

                <div id="receipt-{{ $order->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex justify-center items-center">
                    
                    <div class="bg-white w-80 p-6 rounded shadow-lg relative font-mono text-sm">
                        
                        <button onclick="document.getElementById('receipt-{{ $order->id }}').classList.add('hidden')" 
                                class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 font-bold text-lg">
                            &times;
                        </button>

                        <div class="text-center border-b-2 border-dashed border-gray-300 pb-4 mb-4">
                            <h3 class="text-xl font-bold uppercase tracking-widest">Alumni Coffee</h3>
                            <p class="text-xs text-gray-500">Jl. Kopi Nikmat No. 1</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p class="text-xs text-gray-500">Order ID: #{{ $order->id }}</p>
                        </div>

                        <div class="mb-4 space-y-2">
                            @foreach($order->items as $item)
                            <div class="flex justify-between">
                                <div>
                                    <span class="block font-bold">{{ $item->product_name }}</span>
                                    <span class="text-xs text-gray-500">{{ $item->quantity }} x {{ number_format($item->product_price) }}</span>
                                </div>
                                <div class="font-bold">
                                    {{ number_format($item->quantity * $item->product_price) }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-t-2 border-dashed border-gray-300 pt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span>TOTAL</span>
                                <span>Rp {{ number_format($order->total_price) }}</span>
                            </div>
                            <div class="text-center mt-6 text-xs text-gray-500">
                                *** TERIMA KASIH ***<br>
                                Silakan Datang Kembali
                            </div>
                        </div>

                        <button onclick="document.getElementById('receipt-{{ $order->id }}').classList.add('hidden')" 
                                class="w-full bg-amber-800 text-white py-2 rounded mt-6 hover:bg-amber-900">
                            Tutup
                        </button>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        Belum ada riwayat pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection