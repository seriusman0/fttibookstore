<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use PDF; 

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['menu'])->where('user_id', Auth::id())->get();
        return view('user.order.index', compact('orders'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'jumlah' => 'required|integer|min:1|max:' . $request->input('stok'),
            'notes' => 'nullable|string',
        ]);

        $menu = Menu::findOrFail($validated['menu_id']);
        $total_harga = $menu->harga * $validated['jumlah'];

        DB::beginTransaction(); // Start transaction

        try {
        Order::create([
                'user_id' => Auth::id(),
                'menu_id' => $validated['menu_id'],
                'jumlah' => $validated['jumlah'],
                'total_harga' => $total_harga,
                'status' => 'pending',
                'notes' => $validated['notes'],
            ]);

            // Reduce the stock
            $menu->decrement('stok', $validated['jumlah']);

            DB::commit(); // Commit transaction if all operations succeed

            return redirect()->route('home')->with('success', 'Pesanan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction if any operation fails
            return redirect()->back()->withErrors('Gagal menambahkan pesanan: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $order = Order::with(['user', 'menu'])->findOrFail($id);
        return view('user.order.show', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan,lunas cash,lunas tf',
        ]);

        try {
            $order->update([
                'status' => $validated['status'],
            ]);

            return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diupdate.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Gagal mengupdate status pesanan: ' . $e->getMessage());
        }
}

    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        try {
            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    public function generateInvoice($userId)
    {
        $orders = Order::with(['user', 'menu'])->where('user_id', $userId)->get();
        $totalKeseluruhan = $orders->sum('total_harga');
    
        // Asumsi bahwa semua order milik satu user, ambil username dari order pertama
        $username = $orders->first()->user->username ?? 'Unknown User';
    
        $pdf = PDF::loadView('ordermanager.invoice', compact('orders', 'totalKeseluruhan', 'username'));
    
        return $pdf->stream('invoice_' . $userId . '.pdf');
    }
    
    public function printInvoice($id)
    {
        $order = Order::with(['user', 'menu'])->findOrFail($id);
    
        // Anda bisa menyesuaikan view untuk struk di sini
        $pdf = PDF::loadView('user.order.struk', compact('order'));
    
        return $pdf->stream('struk_order_' . $order->id . '.pdf');
    }
    public function orderManagerIndex()
    {
        $orders = Order::with(['user', 'menu'])->get()->groupBy(function($order) {
            return $order->user->username; // Mengelompokkan berdasarkan username
        });

        return view('ordermanager.index', compact('orders'));
    }


public function updateStatus(Request $request, Order $order)
{
    try {
        $request->validate([
            'status' => 'required|in:pending,diproses,selesai,dibatalkan,lunas cash,lunas tf',
        ]);

        $order->status = $request->status;
        $order->save();

        return response()->json(['message' => 'Status updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
