<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
   public function index() {
        // 1. Ambil semua produk
        $products = Product::all();
        
        // 2. Siapkan variabel kosong dulu (biar gak error kalau Guest)
        $carts = collect([]);
        $orders = collect([]);

        // 3. Kalau user login, baru kita ambil datanya
        if(Auth::check()) {
            $userId = Auth::id();
            
            // Ambil keranjang
            $carts = Cart::where('user_id', $userId)->get();
            
            // Ambil riwayat pesanan (Urutkan dari yang terbaru)
            $orders = Order::where('user_id', $userId)
                           ->orderBy('created_at', 'desc')
                           ->get();
        }

        // 4. Kirim $products, $carts, DAN $orders ke view
        return view('home', compact('products', 'carts', 'orders'));
    }

    public function addToCart($id) {
        if(!Auth::check()) return redirect('/login');

        // Cek apakah user ini sudah pernah masukin produk ini ke keranjang?
        $existingCart = Cart::where('user_id', Auth::id())
                            ->where('product_id', $id)
                            ->first();

        if($existingCart) {
            // Kalau sudah ada, kita tambah jumlahnya saja (Quantity + 1)
            $existingCart->increment('quantity');
        } else {
            // Kalau belum ada, baru kita buat baris baru
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => 1
            ]);
        }
        
        return back()->with('success', 'Berhasil masuk keranjang!');
    }

    public function updateCart(Request $request, $id) {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        
        if($cart) {
            if($request->type == 'plus') {
                $cart->increment('quantity');
            } elseif($request->type == 'minus') {
                // Kalau jumlah lebih dari 1, kurangi. 
                if($cart->quantity > 1) {
                    $cart->decrement('quantity');
                }
            }
        }
        return back();
    }

    public function deleteCart($id) {
        Cart::destroy($id);
        return back();
    }

    // Admin Only
    public function updateProduct(Request $request, $id) {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048' // Validasi gambar
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'is_available' => $request->has('is_available')
        ];

        // LOGIC UPDATE GAMBAR
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama (kalau ada) biar server gak penuh
            if ($product->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($product->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image);
            }
            
            // 2. Simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        
        return back()->with('success', 'Menu dan gambar berhasil diperbarui!');
    }

    public function store(Request $request) {
        // Validasi input (wajib diisi)
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        // Simpan ke database
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'is_available' => true // Default langsung tersedia
        ]);

        return back(); // Kembali ke halaman sebelumnya
    }

    public function checkout() {
        $userId = Auth::id();
        $carts = Cart::where('user_id', $userId)->get();

        if($carts->isEmpty()) return back();

        // 1. Hitung Total
        $totalPrice = $carts->sum(function($cart) {
            return $cart->product->price * $cart->quantity;
        });

        // 2. Buat Order Utama
        $order = Order::create([
            'user_id' => $userId,
            'total_price' => $totalPrice,
            'status' => 'Sudah Bayar'
        ]);

        // 3. SIMPAN DETAIL ITEM (Looping)
        foreach($carts as $cart) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $cart->product->name,
                'product_price' => $cart->product->price,
                'quantity' => $cart->quantity,
            ]);
        }

        // 4. Hapus Keranjang
        Cart::where('user_id', $userId)->delete();

        return back()->with('success', 'Pesanan berhasil dibuat!');
    }
    public function history() {
        $orders = Order::with('items')->where('user_id', Auth::id())
                       ->orderBy('created_at', 'desc')
                       ->get();
                       
        return view('history', compact('orders'));
    }

    public function adminOrders(Request $request) { // <--- Tambahkan Request $request
        if(Auth::user()->role !== 'admin') return redirect('/');

        // 1. Mulai Query (Belum dieksekusi/di-get)
        $query = Order::with(['user', 'items']);

        // 2. Logika FILTER (Berdasarkan Status)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // 3. Logika SORT (Urutkan Data)
        if ($request->has('sort')) {
            if ($request->sort == 'oldest') {
                $query->orderBy('created_at', 'asc'); // Terlama
            } elseif ($request->sort == 'price_high') {
                $query->orderBy('total_price', 'desc'); // Harga Termahal
            } elseif ($request->sort == 'price_low') {
                $query->orderBy('total_price', 'asc'); // Harga Termurah
            } else {
                $query->orderBy('created_at', 'desc'); // Default: Terbaru
            }
        } else {
            // Default kalau tidak ada pilihan sort
            $query->orderBy('created_at', 'desc');
        }

        // 4. Eksekusi Query
        $orders = $query->get();

        return view('admin_orders', compact('orders'));
    }

    // FUNGSI DASHBOARD ADMIN
    public function adminDashboard() {
        if(Auth::user()->role !== 'admin') return redirect('/');

        // 1. Data Kartu Statistik
        $totalRevenue = Order::sum('total_price'); // Total semua uang masuk
        $totalOrders = Order::count(); // Total transaksi
        $totalCustomers = User::where('role', 'customer')->count(); // Total pelanggan
        
        // 2. Data Grafik Penjualan Bulanan (Tahun Ini)
        // Kita siapkan array kosong untuk 12 bulan
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            // Hitung total harga order di bulan $i pada tahun ini
            $monthlyRevenue[] = Order::whereYear('created_at', date('Y'))
                                     ->whereMonth('created_at', $i)
                                     ->sum('total_price');
        }

        return view('admin_dashboard', compact('totalRevenue', 'totalOrders', 'totalCustomers', 'monthlyRevenue'));
    }

    // FUNGSI GALERI MENU (Visual Focus)
    public function menuGallery() {
        // Ambil semua produk
        $products = Product::all();
        return view('menu_gallery', compact('products'));
    }
}

