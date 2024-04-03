<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
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
    $validatedData = $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5000',
        'location' => 'required|string',
        'date' => 'required|date',
        'category_id' => 'required|integer',
        'max_assistants' => 'required|integer|min:1',
        'user_id' => 'required|integer',
    ]);

    // Manejar el archivo de imagen
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);
        $validatedData['image'] = $imageName;
    }

    $event = Event::create($validatedData);

    return response()->json([
        'message' => 'Evento creado exitosamente',
        'data' => $event
    ], 201);
}

    public function update(Request $request, $id)
{
    // Reglas de validación
    $rules = [
        'title' => 'string',
        'description' => 'string',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:5000',
        'location' => 'string',
        'date' => 'date',
        'category_id' => 'integer|min:1|max:2',
        'max_assistants' => 'integer|min:1',
        'user_id' => 'integer',
    ];

    // Mensajes personalizados de validación
    $messages = [
        'category_id.exists' => 'La categoría especificada no existe.',
    ];

    // Validar la solicitud
    $validator = Validator::make($request->all(), $rules, $messages);

    // Si la validación falla, devolver los errores
    if ($validator->fails()) {
        return response()->json(['message' => 'Validation Error!', 'data' => $validator->errors()], 422);
    }

    // Actualizar el evento existente
    $event = Event::findOrFail($id);
    $event->update($request->all());

    return response()->json([
        'message' => 'Event Updated!',
        'data' => $event
    ], 200);
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

    public function getUserEvents($userId)
    {
        // Encuentra al usuario por su ID
        $user = User::findOrFail($userId);
    
        // Recupera los eventos asociados al usuario usando la relación 'events'
        $events = $user->events()->paginate(15);
        return response()->json(['message' => 'Events created by user retrieved successfully', 'data' => $events], 200);
    }
    

}