<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda.index');
    }

    public function getEvents()
    {
        $events = \App\Models\Event::where('is_active', true)->get();
        $formattedEvents = $events->map(function ($event) {
            $tz = config('app.timezone') ?? date_default_timezone_get();

            // All-day single day
            $allDay = empty($event->start_time) && empty($event->end_time);

            // Start: combine event_date and start_time if present, else send date only for all-day
            if ($event->start_time) {
                $startDt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($event->start_time)->format('H:i:s'), $tz);
            } else {
                $startDt = \Carbon\Carbon::createFromFormat('Y-m-d', $event->event_date->format('Y-m-d'), $tz)->startOfDay();
            }

            // Determine end: consider end_date and end_time
            if ($event->end_date) {
                if ($event->end_time) {
                    $endDt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->end_date->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($event->end_time)->format('H:i:s'), $tz);
                } else {
                    // FullCalendar expects end exclusive for all-day; add one day
                    $endDt = \Carbon\Carbon::createFromFormat('Y-m-d', $event->end_date->format('Y-m-d'), $tz)->addDay()->startOfDay();
                }
            } else {
                if ($event->end_time) {
                    $endDt = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $event->event_date->format('Y-m-d') . ' ' . \Carbon\Carbon::parse($event->end_time)->format('H:i:s'), $tz);
                } else {
                    // Single day all-day
                    $endDt = null;
                }
            }

            // Convert to ISO with offset (FullCalendar will interpret with client's timezone correctly)
            $startOutput = $allDay ? $event->event_date->format('Y-m-d') : $startDt->toIso8601String();
            $endOutput = null;
            if ($endDt) {
                // If endDt is a full-day exclusive marker (no time) it already is next-day 00:00
                $endOutput = $endDt->toIso8601String();
            }

            return [
                'title' => $event->title,
                'start' => $startOutput,
                'end' => $endOutput,
                'allDay' => $allDay,
                'backgroundColor' => $event->color ?? '#4B2C20',
                'borderColor' => $event->color ?? '#4B2C20',
                'url' => '#',
                'extendedProps' => [
                    'location' => $event->location,
                    'description' => $event->description
                ]
            ];
        });

        return response()->json($formattedEvents);
    }
}
