@extends('layout')

@section('content')
<div class="max-w-6xl mx-auto mt-4">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">📊 Dashboard Analitik</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalRevenue) }}</p>
            </div>
            <div class="text-green-500 text-4xl">
                <i class="fa-solid fa-money-bill-wave"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Total Pesanan</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }} Transaksi</p>
            </div>
            <div class="text-blue-500 text-4xl">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-amber-500 flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm font-bold uppercase">Pelanggan Terdaftar</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalCustomers }} Orang</p>
            </div>
            <div class="text-amber-500 text-4xl">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">📈 Grafik Pendapatan Bulanan ({{ date('Y') }})</h3>
        <div class="relative h-72 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart');

    // Data dari Controller (dikirim via Blade)
    const monthlyData = @json($monthlyRevenue);

    new Chart(ctx, {
        type: 'line', // Jenis grafik: Line (Garis)
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: monthlyData,
                borderWidth: 3,
                borderColor: '#d97706', // Warna Garis (Amber-600)
                backgroundColor: 'rgba(217, 119, 6, 0.1)', // Warna Arsiran bawah
                tension: 0.3, // Kelengkungan garis
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        // Format angka jadi Rupiah di sumbu Y
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
</script>
@endsection