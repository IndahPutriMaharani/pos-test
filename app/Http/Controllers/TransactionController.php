<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
     public function index()
    {
        // Mengambil semua data menu
        $menus = Menu::all();
        
        // Mengirim data ke view
        return view('transaksi.homeMenu', compact('menus'));    }
}
