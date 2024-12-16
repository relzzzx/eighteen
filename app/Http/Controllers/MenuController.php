<?php

namespace App\Http\Controllers;

use App\Models\Booth;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kategori dari query string
        $category = $request->query('category');
    
        // Ambil semua kategori unik dari menu
        $categories = Menu::select('category')->distinct()->pluck('category')->toArray();
    
        // Filter menu berdasarkan kategori jika ada
        $menus = Menu::when($category, function ($query, $category) {
            return $query->where('category', $category);
        })->get();
    
        // Periksa booth_id pertama dari daftar menu jika tersedia
        $booth_id = $menus->first()->booth_id ?? null;
    
        // Kirimkan variabel menu, booth_id, dan kategori ke View
        return view('menus.index', compact('menus', 'booth_id', 'categories'));
    }      
}


