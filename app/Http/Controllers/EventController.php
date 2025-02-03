<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    // Simpan event ke database
    public function index()
    {
        return response()->json(Event::all());
    }

    // Tampilan untuk kalender
    public function view()
    {
        $event= Event::all();
        return view('components.Calender.event', compact('event'));
    }
    
    // Simpan event baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'nullable|date', // Jika ada kolom 'end'
            'className' => 'string',
            'allDay' => 'boolean',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'extendedProps' => 'nullable|array', // Validasi extendedProps sebagai array
        ]);

        // Menyimpan event baru
        $event = Event::create($request->all());

        return response()->json($event, 201);
         
    }

    // Ambil event berdasarkan ID
    public function show(Event $event)
    {
        return response()->json($event);
    }

    // Update event berdasarkan ID
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'string',
            'start' => 'date',
            'end' => 'nullable|date', // Update validasi untuk kolom 'end'
            'className' => 'string',
            'allDay' => 'boolean',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'extendedProps' => 'nullable|array', // Validasi extendedProps
        ]);

        $event->update($request->all());

        return response()->json($event);
    }

    // Hapus event berdasarkan ID
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted successfully']);
    }
}
