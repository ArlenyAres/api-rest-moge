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

        if ($request->has('category_id')) {
            $category_id = $request->input('category_id');
            $eventsQuery->where('category_id', $category_id);
        }

        // Obtener eventos paginados
        $events = $eventsQuery->paginate(15);

        // Iterar sobre cada evento para agregar los detalles del usuario y corregir la URL de la imagen
        foreach ($events as $event) {
            // Corregir la URL de la imagen del evento
            $event->image_url = $event->image ? url("storage/images/$event->image") : null;

            // Obtener y agregar los detalles del usuario
            $user = User::findOrFail($event->user_id);
            $event->user_name = $user->name;
            // Corregir la URL de la imagen del usuario
            $event->user_image_url = $user->image_path ? url("storage/images/users/$user->image_path") : null;
        }

        // Devolver la respuesta JSON con los eventos actualizados
        return response()->json(['message' => 'Events retrieved successfully', 'data' => $events], 200);
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
            'location' => 'required|string',
            'date' => 'required|date',
            'category_id' => 'required|integer|min:1',
            'max_assistants' => 'required|integer|min:1',
            'user_id' => 'required|integer',
        ]);

        try {
            // Manejar el archivo de imagen del evento
            if ($request->hasFile('image')) {
                // Obtener la imagen del evento
                $image = $request->file('image');

                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $imagePath = $image->storeAs('public/images', $imageName);
                $validatedData['image'] = $imageName; // Almacena el nombre del archivo de imagen en el campo 'image'
            }

            $event = Event::create($validatedData);

            $imageUrl = $event->image ? url("storage/images/$event->image") : null;
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
        // Definir las reglas de validación inicialmente vacías
        $rules = [];

        // Validar solo los campos que se proporcionan en la solicitud
        if ($request->filled('title')) {
            $rules['title'] = 'nullable|string|max:250';
        }

        if ($request->filled('description')) {
            $rules['description'] = 'nullable|string';
        }

        if ($request->hasFile('image')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000';
        }

        if ($request->filled('location')) {
            $rules['location'] = 'nullable|string';
        }

        if ($request->filled('date')) {
            $rules['date'] = 'nullable|date';
        }

        if ($request->filled('category_id')) {
            $rules['category_id'] = 'nullable|integer|min:1|max:2';
        }

        if ($request->filled('max_assistants')) {
            $rules['max_assistants'] = 'nullable|integer|min:1';
        }

        if ($request->filled('user_id')) {
            $rules['user_id'] = 'nullable|integer';
        }

        // Validar los campos de acuerdo a las reglas definidas
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        $event = Event::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images', $imageName);
            $event->image = $imageName;
        }

        // Usar fill() para asignar los nuevos valores
        $event->fill($request->except(['image', '_method', '_token'])); // Actualiza todos los campos excepto la imagen

        // Guardar los cambios en el evento
        $event->save();

        if ($event->user) {
            $user = $event->user;
            $userImageUrl = url("storage/images/users/$user->image_path");
            $user->image_url = $userImageUrl;
        }


        $eventImageUrl = $event->image ? url("storage/images/$event->image") : null;
        $event->image_url = $eventImageUrl;

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

        $imageUrl = $event->image ? url("storage/images/$event->image") : null;
        $event->image_url = $imageUrl;

        $user = $event->user;

        if (!$user) {
            return response()->json(['message' => 'User not found for this event'], 404);
        }

        $userImageUrl = $user->image_path ? url("storage/images/users/$user->image_path") : null;
        $event->user_image_url = $userImageUrl;

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
        if ($registeredUsers->isEmpty()) {
            return response()->json(['message' => 'No registered users found for this event'], 404);
        }

        if ($registeredUsers->isNotEmpty()) {
            foreach ($registeredUsers as $user) {
                $imageUrl = url("storage/$user->image_path");
                $user->image_url = $imageUrl;
            }
        }

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
