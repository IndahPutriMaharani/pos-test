<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // TAB FOOD
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
            'name'  => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image'
        ]);

        $path = $request->file('image')->store('menus', 'public');

        Menu::create([
            'name'  => $request->name,
            'price' => $request->price,
            'image' => 'storage/' . $path
        ]);

        return redirect('/food')
                ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $menu->update([
            'name'  => $request->name,
            'price' => $request->price
        ]);

        // jika user upload gambar baru
        if ($request->hasFile('image')) {

            // hapus gambar lama (opsional tapi disarankan)
            if ($menu->image && file_exists(public_path($menu->image))) {
                unlink(public_path($menu->image));
            }

            $path = $request->file('image')->store('menus', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $menu->update($data);

        return redirect('/food')->with('success', 'Menu berhasil diupdate');
    }

    public function destroy($id)
    {
        Menu::destroy($id);
        return redirect('/food')->with('success', 'Menu berhasil dihapus');
    }

}
