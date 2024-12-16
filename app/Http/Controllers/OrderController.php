<?php

namespace App\Http\Controllers;

use App\Models\Booth;
use App\Models\Menu;
use App\Models\Order;
use App\Models\Payment;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Endpoint untuk membuat pesanan
    public function create(Request $request, $booth_id)
{
    $request->validate([
        'payment_method' => 'required|in:cash,qris',
    ]);

    $booth = Booth::findOrFail($booth_id);

    if ($booth->name === 'Pakde' && $request->payment_method === 'qris') {
        return back()->withErrors(['payment_method' => 'QRIS tidak tersedia untuk booth Pakde.']);
    }

    $status = $request->payment_method === 'cash' ? 'approved' : 'pending';

    $subtotal = collect($request->order_items)->sum(function ($item) {
        return Menu::findOrFail($item['menu_id'])->price * $item['quantity'];
    });

    $tax = $request->payment_method === 'qris' ? 1000 : 0;

    try {
        $order = Order::create([
            'user_id' => Auth::id(),
            'booth_id' => $booth_id,
            'payment_method' => $request->payment_method,
            'status' => $status,
            'total_price' => $subtotal + $tax, // Tambahkan pajak jika QRIS
        ]);

        if (!$order) {
            return back()->with('error', 'Gagal menyimpan pesanan.');
        }

        if ($request->payment_method === 'qris') {
            return redirect()->route('payments.create', ['order' => $order->id]);
        }

        return redirect()->route('orders.status', ['order' => $order->id]);
    } catch (\Exception $e) {
        return back()->withErrors(['error' => $e->getMessage()]);
    }
}
    



    // Halaman untuk melihat status pesanan
    public function showStatus($order_id)
    {
        $query = Order::where('id', $order_id);
    
        // Jika user bukan admin, filter berdasarkan user_id
        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id()); // Hanya pesanan milik user yang bisa dilihat
        }
    
        $order = $query->firstOrFail();
    
        // Hitung subtotal dari pesanan
        $subtotal = $order->orderItems->sum(fn($item) => $item->menu->price * $item->quantity);
    
        // Hitung biaya tambahan pajak jika metode pembayaran menggunakan QRIS
        $tax = 0;
        if ($order->payment_method === 'qris') {
            $tax = 1000; // Biaya tetap Rp 1.000 jika menggunakan QRIS
        }
    
        return view('orders.status', compact('order', 'tax'));
    }
    



    // Endpoint untuk meng-upload bukti pembayaran QRIS
    public function uploadPaymentProof(Request $request, $order_id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $payment = Payment::create([
            'order_id' => $order_id,
            'proof_image' => $request->file('proof_image')->store('payments'),
            'status' => 'pending',
        ]);

        return redirect()->route('orders.status', ['order' => $order_id]);
    }

    public function bulkCreate(Request $request, $booth_id)
{
    $request->validate([
        'quantities' => 'required|array',
        'payment_method' => 'required|in:cash,qris',
        'notes' => 'nullable|string|max:255',
    ]);

    $quantities = array_filter($request->quantities, function ($qty) {
        return $qty > 0;
    });

    if (empty($quantities)) {
        return back()->with('error', 'Pilih minimal satu menu dengan jumlah lebih dari 0.');
    }

    $subtotal = 0;

    // Hitung subtotal berdasarkan menu yang dipilih
    foreach ($quantities as $menu_id => $qty) {
        $menu = Menu::findOrFail($menu_id);
        $subtotal += $menu->price * $qty;
    }

    // Hitung pajak jika metode pembayaran QRIS
    $tax = $request->payment_method === 'qris' ? 1000 : 0;

    // Ambil notes jika ada
    $notes = $request->has('notes') ? $request->input('notes') : null;

    // Buat pesanan (Order)
    $order = Order::create([
        'user_id' => Auth::id(),
        'booth_id' => $booth_id,
        'payment_method' => $request->payment_method,
        'notes' => $notes,
        'status' => $request->payment_method === 'qris' ? 'pending' : 'approved',
        'total_price' => $subtotal + $tax, // Tambahkan pajak jika QRIS
    ]);

    // Menambahkan item pesanan ke dalam tabel order_items
    foreach ($quantities as $menu_id => $qty) {
        $menu = Menu::findOrFail($menu_id); // Ambil menu berdasarkan ID
        $boothId = $menu->booth_id; // Ambil booth_id dari menu terkait

        // Pastikan booth_id yang sesuai dengan menu digunakan untuk tiap item
        OrderItem::create([
            'order_id' => $order->id,
            'menu_id' => $menu_id,
            'quantity' => $qty,
            'booth_id' => $boothId, // Masukkan booth_id dari menu yang sesuai
        ]);
    }

    // Jika pembayaran menggunakan QRIS, arahkan ke halaman pembayaran
    if ($request->payment_method === 'qris') {
        return redirect()->route('payments.show', $order->id);
    }

    // Setelah berhasil membuat pesanan, kembali ke status pesanan
    return redirect()->route('orders.status', $order->id)->with('success', 'Pesanan berhasil dibuat.');
}




public function manageOrders()
{
    $userId = auth()->id();
    
    // Ambil semua pesanan dengan status yang sesuai dan booth yang di-manage admin
    $orders = Order::where('status', 'approved')
    ->where('booth_id', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })
    ->with('booth', 'user')
    ->orderBy('created_at', 'desc')
    ->get();

    
    return view('orders.manage', compact('orders'));
}



    
    public function approvePayment($payment_id)
    {
        // Cari payment berdasarkan ID
        $payment = Payment::findOrFail($payment_id);
    
        // Set status pembayaran menjadi approved
        $payment->status = 'approved';
        $payment->save();
    
        // Update status pesanan menjadi 'approved'
        $order = $payment->order;
        $order->status = 'approved';
        $order->save();
    
        return redirect()->route('orders.manage')->with('success', 'Pembayaran QRIS disetujui.');
    }

    public function declinePayment($payment_id)
    {
        $payment = Payment::findOrFail($payment_id);
        $payment->status = 'declined';
        $payment->save();
    
        return redirect()->route('orders.manage')->with('error', 'Pembayaran QRIS ditolak.');
    }

    public function completeOrder($order_id)
{
    $order = Order::findOrFail($order_id);
    
    if ($order->status === 'approved') {
        $order->status = 'completed';
        $order->save();
        return redirect()->route('orders.manage')->with('success', 'Pesanan selesai!');
    }

    return redirect()->route('orders.manage')->with('error', 'Pesanan tidak dalam status yang dapat diselesaikan.');
}


    public function myOrdersSearch(Request $request)
{
    $query = Order::where('user_id', auth()->id()); // Hanya pesanan milik pengguna yang login

    // Tambahkan filter berdasarkan kriteria
    if ($request->has('status') && $request->status !== null) {
        $query->where('status', $request->status);
    }

    if ($request->has('order_id') && $request->order_id !== null) {
        $query->where('id', $request->order_id);
    }

    if ($request->has('booth_name') && $request->booth_name !== null) {
        $query->whereHas('booth', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->booth_name . '%');
        });
    }

    $orders = $query->latest()->paginate(10); // Paginate hasil pencarian

    return view('orders.my-search', compact('orders'));
}
    
    public function userOrders()
{
    $orders = Order::where('user_id', auth()->id())->get();

    return view('orders.index', compact('orders'));
}

    public function show($id)
{
    $order = Order::with('orderItems.menu', 'payment')->findOrFail($id);

    // Perhitungkan pajak
    $subtotal = $order->orderItems->sum(fn($item) => $item->menu->price * $item->quantity);
    $taxRate = 0.01; // Pajak 1%
    $tax = ceil($subtotal * $taxRate);

    return view('order.print', compact('order', 'tax'));
}


public function status(Order $order)
{
    $user = auth()->user(); // Ambil data pengguna yang sedang login

    // Periksa apakah pengguna dengan role 'user' hanya bisa melihat pesanan mereka sendiri
    if ($user->role === 'user' && $order->user_id !== $user->id) {
        abort(403, 'Anda tidak memiliki izin untuk melihat pesanan ini.'); // Tolak akses
    }

    // Hitung pajak tambahan jika metode pembayaran QRIS digunakan
    $tax = 0;
    if ($order->payment_method === 'qris') {
        $tax = 1000; // Biaya tetap Rp 1.000 untuk pembayaran QRIS
    }

    return view('orders.status', compact('order', 'tax'));
}


public function index()
{
    $orders = Order::query()
        ->when(!Auth::user()->is_admin, function ($query) {
            // Jika bukan admin, hanya ambil pesanan milik user tersebut
            $query->where('user_id', Auth::id());
        })
        ->with(['orderItems.menu']) // Pastikan eager loading untuk menghindari N+1 query
        ->get();

    return view('orders.index', compact('orders'));
}

}
