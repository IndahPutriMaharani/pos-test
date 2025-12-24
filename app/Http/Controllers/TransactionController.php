<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('transaksi.homeMenu', compact('menus'));
    }
    public function store(Request $request){
        DB::transaction(function () use ($request) {

            $trx = Transaction::create([
                'subtotal' => $request->subtotal,
                'fee'      => $request->fee,
                'total'    => $request->total,
                'cash'     => $request->cash,
                'change'   => $request->change,
            ]);

            foreach ($request->items as $item) {
                TransactionItem::create([
                    'transaction_id' => $trx->id,
                    'menu_name'      => $item['name'],
                    'price'          => $item['price'],
                    'qty'            => $item['qty'],
                    'subtotal'       => $item['price'] * $item['qty'],
                ]);
            }
        });

        return response()->json(['status' => 'success']);
    }
}
