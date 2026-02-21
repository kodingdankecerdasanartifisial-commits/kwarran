<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = \App\Models\Menu::whereNull('parent_id')->orderBy('order')->with('children')->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        \App\Models\Menu::create($request->all());

        return redirect()->back()->with('success', 'Menu added successfully.');
    }

    public function update(Request $request, \App\Models\Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'url' => 'required',
        ]);

        $menu->update($request->all());

        return redirect()->back()->with('success', 'Menu updated successfully.');
    }

    public function destroy(\App\Models\Menu $menu)
    {
        $menu->delete();
        return redirect()->back()->with('success', 'Menu deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        $menuOrder = $request->input('order');
        $this->orderMenu($menuOrder, null);

        return response()->json(['success' => true]);
    }

    private function orderMenu(array $menuItems, $parentId)
    {
        foreach ($menuItems as $index => $menuItem) {
            $menu = \App\Models\Menu::find($menuItem['id']);
            $menu->order = $index + 1;
            $menu->parent_id = $parentId;
            $menu->save();

            if (isset($menuItem['children'])) {
                $this->orderMenu($menuItem['children'], $menu->id);
            }
        }
    }
}
