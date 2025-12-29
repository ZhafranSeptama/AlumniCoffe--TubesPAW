@extends('layout')
@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <form action="/login" method="POST">
        @csrf
        <input type="email" name="email" placeholder="Email" class="w-full border p-2 mb-2" required>
        <input type="password" name="password" placeholder="Password" class="w-full border p-2 mb-4" required>
        <button class="w-full bg-amber-600 text-white py-2 rounded">Masuk</button>
    </form>
</div>
@endsection