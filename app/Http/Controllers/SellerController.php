<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SellerController extends Controller
{
    public function orders()
    {
        $user = auth()->user(); // Ambil data pengguna yang sedang login

        // Cari booth_id pengguna saat ini dari tabel booths
        $booth = DB::table('booths')->where('user_id', $user->id)->first();

        if (!$booth) {
            abort(403, 'Booth Anda tidak ditemukan');
        }

        $boothId = $booth->id; // Ambil booth_id yang sesuai dengan pengguna saat ini

        // Ambil pesanan yang hanya berisi menu dari booth ini
        $orders = Order::where('status', 'Completed') // Hanya ambil pesanan dengan status 'Completed'
        ->whereHas('items', function ($query) use ($boothId) {
            $query->where('booth_id', $boothId);
        })
        ->with(['items.menu', 'user']) // Pastikan relasi 'menu' dan 'user' dimuat
        ->get();
    
        
        // Kirim data boothId dan orders ke view
        return view('seller.orders', compact('orders', 'boothId'));
    }

    public function index()
    {
        $booth = DB::table('booths')->where('user_id', auth()->user()->id)->first();
        
        if (!$booth) {
            abort(403, 'Booth Anda tidak ditemukan');
        }
    
        $boothId = $booth->id;
    
        // Ambil hanya pesanan dengan item yang memiliki booth_id sama dengan booth login
        $orders = Order::whereHas('items', function ($query) use ($boothId) {
            $query->where('booth_id', $boothId);
        })->with('items')->get();
    
        return view('sellers.orders', compact('orders', 'boothId'));
    }
    
}
