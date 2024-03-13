<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Devuelve todos los eventos
        return Event::all();
    }

    public function store(Request $request)
    {
        // Crea un nuevo evento
        $event = Event::create($request->all());
        return response()->json($event, 201);
    }

    public function update(Request $request, $id)
    {
        // Actualiza un evento existente
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        // Elimina un evento
        Event::destroy($id);
        return response()->json(null, 204);
    }
}