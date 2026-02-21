<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SidebarWidget;
use Illuminate\Http\Request;

class SidebarWidgetController extends Controller
{
    public function index()
    {
        $widgets = SidebarWidget::orderBy('order')->get();
        return view('admin.sidebar_widgets.index', compact('widgets'));
    }

    public function create()
    {
        return view('admin.sidebar_widgets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'title' => 'nullable|string|max:191',
            'type' => 'required|in:agenda,popular,html,visitor',
            'content' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');
        SidebarWidget::create($data);

        return redirect()->route('admin.sidebar-widgets.index')->with('success', 'Widget berhasil ditambahkan.');
    }

    public function edit(SidebarWidget $sidebarWidget)
    {
        return view('admin.sidebar_widgets.edit', compact('sidebarWidget'));
    }

    public function update(Request $request, SidebarWidget $sidebarWidget)
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'title' => 'nullable|string|max:191',
            'type' => 'required|in:agenda,popular,html,visitor',
            'content' => 'nullable|string',
            'url' => 'nullable|url',
            'order' => 'nullable|integer',
        ]);

        $data['is_active'] = $request->has('is_active');
        $sidebarWidget->update($data);

        return redirect()->route('admin.sidebar-widgets.index')->with('success', 'Widget berhasil diperbarui.');
    }

    public function destroy(SidebarWidget $sidebarWidget)
    {
        $sidebarWidget->delete();
        return redirect()->route('admin.sidebar-widgets.index')->with('success', 'Widget berhasil dihapus.');
    }
}
