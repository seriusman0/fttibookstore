<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('usermanager.index', compact('users'));
    }
    public function showLoginForm()
    {
        return view('login'); // Menampilkan view login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);
    
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }
    
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }
    public function showHome()
{
    // Ambil data menu dari database (sesuaikan dengan query Anda)
    $menu = Menu::all(); 

    return view('user.home', compact('menu'));
}
public function logout(Request $request)    {        Auth::logout();        $request->session()->invalidate();        $request->session()->regenerateToken();        return redirect('/login');    
}


    public function showRegistrationForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

     // Menampilkan form tambah pengguna
     public function create()
     {
         $roles = Role::all();
         return view('usermanager.create', compact('roles'));
     }
 
     // Menyimpan data pengguna baru
     public function store(Request $request)
     {
         $request->validate([
             'username' => 'required|unique:users',
             'password' => 'required|min:6',
             'role' => 'required'
         ]);
 
         $user = User::create([
             'username' => $request->username,
             'password' => Hash::make($request->password),
         ]);
 
         $user->assignRole($request->role);
 
         return redirect()->route('usermanager.index')->with('success', 'User berhasil ditambahkan.');
     }
 
     // Menampilkan detail pengguna
     public function show($id)
     {
         $user = User::findOrFail($id);
         return view('usermanager.show', compact('user'));
     }
 
     // Menampilkan form edit pengguna
     public function edit($id)
     {
         $user = User::findOrFail($id);
         $roles = Role::all();
         return view('usermanager.edit', compact('user', 'roles'));
     }
 
     // Memperbarui data pengguna
     public function update(Request $request, $id)
     {
         $user = User::findOrFail($id);
 
         $request->validate([
             'username' => 'required|unique:users,username,' . $id,
             'role' => 'required'
         ]);
 
         $user->update([
             'username' => $request->username,
         ]);
 
         if ($request->filled('password')) {
             $user->update(['password' => Hash::make($request->password)]);
         }
 
         $user->syncRoles([$request->role]);
 
         return redirect()->route('usermanager.index')->with('success', 'User berhasil diperbarui.');
     }
     public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('usermanager.index')->with('success', 'User berhasil dihapus.');
}
}
