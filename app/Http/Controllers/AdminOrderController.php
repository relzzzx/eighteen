<?php

namespace App\Http\Controllers;

use App\Models\Order;

class AdminOrderController extends Controller
{
    // Menampilkan semua pesanan
    public function index()
    {
        $orders = Order::with(['user', 'orderItems.menu'])
            ->latest()
            ->get()
            ->map(function ($order) {
                // Tambahkan pajak: 1000 untuk QRIS
                $tax = $order->payment_method === 'qris' ? 1000 : 0;
                $order->tax = $tax;
                return $order;
            });

        return view('admin.orders.index', compact('orders'));
    }

    // Menyetujui pesanan
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Pesanan disetujui');
    }

    // Menolak pesanan
    public function decline($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'declined']);
        return redirect()->back()->with('success', 'Pesanan ditolak');
    }

    // Menyelesaikan pesanan
    public function completeOrder($order_id)
    {
        $order = Order::findOrFail($order_id);

        if ($order->status === 'approved') {
            $order->status = 'completed';
            $order->save();
            return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil diselesaikan.');
        }

        return redirect()->route('admin.orders.index')->with('error', 'Pesanan tidak dalam status yang dapat diselesaikan.');
    }

    // Menampilkan pendapatan dan pajak per booth
    public function showRevenues()
    {
        // Ambil pesanan completed dengan relasi
        $orders = Order::where('status', 'completed')->with('orderItems.booth', 'orderItems.menu')->get();
    
        // Inisialisasi variabel untuk pendapatan kotor dan pajak
        $totalGrossRevenue = 0;
        $totalTax = 0;
        $boothRevenues = [];
    
        foreach ($orders as $order) {
            // Hitung subtotal untuk pesanan
            $orderRevenue = 0;
    
            foreach ($order->orderItems as $orderItem) {
                $boothId = $orderItem->booth->id;
                $boothName = $orderItem->booth->name;
    
                // Hitung pendapatan item
                $itemRevenue = $orderItem->menu->price * $orderItem->quantity;
                $orderRevenue += $itemRevenue;
    
                // Kelompokkan pendapatan ke booth
                if (!isset($boothRevenues[$boothId])) {
                    $boothRevenues[$boothId] = [
                        'booth_name' => $boothName,
                        'total_revenue' => 0
                    ];
                }
                $boothRevenues[$boothId]['total_revenue'] += $itemRevenue;
            }
    
            // Tambahkan pendapatan pesanan ke pendapatan kotor
            $totalGrossRevenue += $orderRevenue;
    
            // Tambahkan pajak jika metode pembayaran QRIS
            if ($order->payment_method === 'qris') {
                $totalTax += 1000; // Pajak tetap per pesanan QRIS
            }
        }
    
        // Kirim data ke view
        return view('admin.revenue', compact('boothRevenues', 'totalGrossRevenue', 'totalTax'));
    }
    
     
    
    
}
