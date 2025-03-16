<?php
namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('menu.index', compact('menus'));
    }

    public function create()
    {
        return view('menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_menu' => 'required|string|max:12',
            'nama' => 'required|string|max:100',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori' => 'nullable|string|max:100',
            'stok' => 'integer|min:1',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $imageName = time().'.'.$request->gambar->extension();  
            $request->gambar->move(public_path('img'), $imageName);
            $data['gambar'] = $imageName;
        }

        Menu::create($data);

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    public function show(Menu $menu)
    {
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
{
    $request->validate([
        'kode_menu' => 'required|string|max:12|unique:menus,kode_menu,' . $menu->id,
        'nama' => 'required|string|max:100',
        'harga' => 'required|numeric',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'kategori' => 'required|string|max:100',
        'stok' => 'required|integer|min:1',
    ]);

    $data = $request->all();

    // Jika ada gambar baru yang diupload
    if ($request->hasFile('gambar')) {
        // Hapus gambar lama jika ada
        if ($menu->gambar) {
            Storage::delete('img/' . $menu->gambar); // Pastikan Anda menyesuaikan path sesuai dengan penyimpanan Anda
        }
        
        // Upload gambar baru
        $imageName = time() . '.' . $request->gambar->extension();  
        $request->gambar->move(public_path('img'), $imageName);
        $data['gambar'] = $imageName; // Simpan nama gambar baru
    } else {
        // Jika tidak ada gambar baru, tetap gunakan gambar lama
        $data['gambar'] = $menu->gambar; 
    }

    $menu->update($data);

    return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
}

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }
    public function search(Request $request)
{
    $query = $request->get('query');
    $menu = Menu::where('nama', 'LIKE', "%{$query}%")->get(); // Adjust the model and column name as necessary
    return response()->json($menu);
}
}
