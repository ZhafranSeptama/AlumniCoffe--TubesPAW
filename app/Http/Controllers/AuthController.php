<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    
    public function login(Request $request) {
    if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // UBAH DARI '/' MENJADI route('home')
        return redirect()->route('home'); 
    }
    return back()->with('error', 'Email/Password salah!');
}

    public function showRegister() { return view('auth.register'); }

    public function register(Request $request) {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer'
        ]);
        Auth::login($user);
        return redirect()->route('home');
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
