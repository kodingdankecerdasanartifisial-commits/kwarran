<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'desc')->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|max:255',
            'color' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($request->title) . '-' . time();
        $validated['is_active'] = $request->has('is_active');
        // Manually assign attributes not in validated array if necessary, or merge
        if ($request->has('start_time')) $validated['start_time'] = $request->start_time;
        if ($request->has('end_time')) $validated['end_time'] = $request->end_time;
        if ($request->has('end_date')) $validated['end_date'] = $request->end_date;
        if ($request->has('color')) $validated['color'] = $request->color;

        Event::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'event_date' => 'required|date',
            'end_date' => 'nullable|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|max:255',
            'color' => 'nullable|string',
        ]);

        $event->is_active = $request->has('is_active');
        $event->start_time = $request->start_time;
        $event->end_time = $request->end_time;
        $event->end_date = $request->end_date;
        $event->color = $request->color;
        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
