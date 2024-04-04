<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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
            'category_id' => 'required|integer|min:1',
            'max_assistants' => 'required|integer|min:1',
            'user_id' => 'required|integer',
        ]);
    
        try {
            // Manejar el archivo de imagen del evento
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/images', $imageName);
                $validatedData['image'] = $imageName; // Almacena el nombre del archivo de imagen en el campo 'image'
            }
    
            $event = Event::create($validatedData);
    
            $imageUrl = url("storage/images/$imageName");
            $event->image_url = $imageUrl;
    
            return response()->json([
                'message' => 'Evento creado exitosamente',
                'data' => $event
            ], 201);
        } catch (\Exception $e) {
            // Manejar el error
            Log::error('Error durante la creación del evento: ' . $e->getMessage());
            return response()->json(['error' => 'Error durante la creación del evento'], 500);
        }
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
    
        // Actualizar el campo de imagen si se proporciona una nueva imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $event->image = $imageName; // Almacena el nombre del archivo de imagen en el campo 'image'
        }
    
        $event->update($request->all());
    
        // Construir la URL de la imagen del evento
        $imageUrl = url("storage/images/$event->image");
        $event->image_url = $imageUrl;
    
        return response()->json([
            'message' => 'Event Updated!',
            'data' => $event
        ], 200);
    }

    public function show($id)
    {
        $event = Event::find($id);
    
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
    
        // Construir la URL de la imagen del evento
        $imageUrl = url("storage/images/$event->image");
        $event->image_url = $imageUrl;
    
        // Devolver el evento encontrado con la URL de la imagen
        return response()->json(['data' => $event], 200);
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        $event->delete();
        return response()->json(['message' => 'Event deleted OK'], 200);
    }


    public function getRegisteredUsers($eventId)
    {
        $event = Event::findOrFail($eventId);
        $registeredUsers = $event->registeredUsers()->paginate(5); 
        return response()->json(['message' => 'Registered users retrieved successfully', 'data' => $registeredUsers], 200);
    }

    public function getUserEvents($userId)
    {
        $user = User::findOrFail($userId);

        $events = $user->events()->paginate(15);
        foreach ($events as $event) {
            $imageUrl = url("storage/images/$event->image");
            $event->image_url = $imageUrl;
        }

        return response()->json(['message' => 'Events created by user retrieved successfully', 'data' => $events], 200);
    }
}
