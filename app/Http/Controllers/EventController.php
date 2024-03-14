<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index(Request $request)
    {
        $eventsQuery = Event::query();

        // Filtra si se proporciona un parametro de categoria por el input
        if ($request->has('category_id')) {
            $category_id = $request->input('category_id');
            $eventsQuery->where('category_id', $category_id);
        }

        // si no muentra todos los eventos con paginacion hasta 15
        $events = $eventsQuery->paginate(15);

        return response()->json($events, 200);
    }

    public function indexByCategory(Request $request, $id)
    {
        $eventsQuery = Event::query()->where('category_id', $id);

        // Paginar los resultados hasta 15
        $events = $eventsQuery->paginate(15);

        return response()->json($events, 200);
    }


    public function store(Request $request)
    {
        // Crea un nuevo evento
        $event = Event::create($request->all());
        return response()->json([
            'message' => 'Event Create!',
            'data'=> $event],
            201);
    }

    public function update(Request $request, $id)
    {
        // Actualiza un evento existente
        $event = Event::findOrFail($id);
        $event->update($request->all());
        return response()->json([
                'message' => 'Evente Update!',
                'data' => $event
            ], 200 );
    }

    public function show($id)
    {
        // Buscar el evento por su ID
        $event = Event::find($id);

        // Verificar si el evento existe
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Devolver el evento encontrado
        return response()->json(['data' => $event], 200);
    }


    public function destroy($id)
    {
        // Buscar el evento por su ID
        $event = Event::find($id);

        // Verificar si el evento existe
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        // Eliminar el evento
        $event->delete();

        // Devolver una respuesta indicando que el evento ha sido eliminado exitosamente
        return response()->json(['message' => 'Event deleted OK'], 200);
    }

    public function getRegisteredUsers($eventId)
    {
        $event = Event::findOrFail($eventId);
        $registeredUsers = $event->registeredUsers()->paginate(5); // Paginacion a 5 pa que se vean el numero de usuarios registrados
        return response()->json(['message' => 'Registered users retrieved successfully', 'data' => $registeredUsers], 200);
    }

}