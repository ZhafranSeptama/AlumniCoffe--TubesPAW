@extends('layout')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded shadow-md mt-10">
    <h2 class="text-2xl font-bold mb-6 text-center text-amber-800">Daftar Pelanggan Baru</h2>
    
    <form action="/register" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
            <input type="text" name="name" placeholder="Contoh: Budi Santoso" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-amber-500" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" name="email" placeholder="Contoh: budi@gmail.com" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-amber-500" required>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" name="password" placeholder="Minimal 3 karakter" 
                   class="w-full border border-gray-300 p-2 rounded focus:outline-none focus:border-amber-500" required>
        </div>

        <button type="submit" class="w-full bg-amber-600 text-white font-bold py-2 px-4 rounded hover:bg-amber-700 transition">
            Daftar Sekarang
        </button>

        <div class="mt-4 text-center text-sm">
            Sudah punya akun? <a href="/login" class="text-amber-600 font-bold">Login disini</a>
        </div>
    </form>
</div>
@endsection