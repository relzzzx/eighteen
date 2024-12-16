<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booth;

class BoothController extends Controller
{
    public function index()
    {
        $booths = Booth::all(); // Ambil semua booth
        return view('booths.index', compact('booths'));
    }

    public function create()
    {
        return view('booths.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file foto
    ]);

    $photoUrl = null;
    if ($request->hasFile('photo')) {
        // Buat nama file berdasarkan nama booth
        $fileName = \Illuminate\Support\Str::slug($request->name) . '.' . $request->file('photo')->getClientOriginalExtension();

        // Simpan file ke folder storage/public/booth_photos
        $path = $request->file('photo')->storeAs('booth_photos', $fileName, 'public');
        $photoUrl = \Illuminate\Support\Facades\Storage::url($path);
    }

    // Simpan data booth ke database
    Booth::create([
        'name' => $request->name,
        'description' => $request->description,
        'user_id' => auth()->id(),
        'status' => true,
        'photo_url' => $photoUrl, // Simpan URL foto jika ada
    ]);

    return redirect()->route('booths.index');
}


    public function destroy(Booth $booth)
    {
        $booth->delete();
        return redirect()->route('booths.index');
    }

    public function toggleStatus(Booth $booth)
{
    // Periksa apakah user memiliki peran sebagai 'penjual'
    if (auth()->user() && auth()->user()->role !== 'penjual') {
        return back()->with('error', 'Anda tidak memiliki izin untuk mengubah status booth');
    }

    // Toggle status booth
    $booth->status = $booth->status === 'open' ? 'closed' : 'open';
    $booth->save();

    return back()->with('status', 'Status booth berhasil diperbarui');
}

}