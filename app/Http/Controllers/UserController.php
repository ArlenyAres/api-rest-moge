<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Model\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{

    public function getEventsCreatedByUser($id)
    {
        $user = User::findOrFail($id);
        $eventsCreated = $user->events()->paginate(15); //paginacion
        return response()->json(['message' => 'Events created by user retrieved successfully', 'data' => $eventsCreated], 200);
    }



    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Definir las reglas de validación inicialmente vacías
        $rules = [];

        // Validar solo los campos que se proporcionan en la solicitud
        if ($request->filled('name')) {
            $rules['name'] = 'nullable|string|max:250';
        }

        if ($request->filled('email')) {
            $rules['email'] = 'nullable|string|email:rfc,dns|max:250|unique:users,email,' . $user->id;
        }

        if ($request->filled('password')) {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        if ($request->hasFile('image')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000';
        }

        // Validar los campos de acuerdo a las reglas definidas
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        // Usar fill() para asignar los nuevos valores
        $user->fill($request->only(['name', 'email']));

        // Verificar si se proporcionó una nueva contraseña
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Verificar si se proporcionó una nueva imagen
        if ($request->hasFile('image')) {
            // Obtener el archivo y su extensión
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            // Almacenar la imagen y obtener la ruta
            $imagePath = $image->storeAs('images/users', $imageName, 'public');

            // Actualizar el path de la imagen en el modelo de usuario
            $user->image_path = $imagePath;
        }

        // Guardar los cambios en el usuario
        $user->save();

        // Construir la URL de la imagen
        $imageUrl = $user->image_path ? url("storage/images/users/$user->image_path") : null;

        $user->image_url = $imageUrl;

        return response()->json(['message' => 'User profile updated successfully', 'data' => $user], 200);
    }




    public function getUserProfile($id)
    {
        $user = User::findOrFail($id);
        
        // Construir la URL de la imagen
        $imageUrl = url("storage/$user->image_path");
        
        // Agregar la URL de la imagen al objeto de usuario
        $user->image_url = $user->image_path ? $imageUrl : null;
        
        // Devolver la respuesta JSON con la URL de la imagen
        return response()->json(['message' => 'User profile retrieved successfully', 'data' => $user], 200);
    }

    // 
    public function deleteUser($id)
    {
        // Encontrar y eliminar al usuario con el ID proporcionado
        $user = User::findOrFail($id);
        $user->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    public function getSubscribedEvents($id)
{
    $user = User::findOrFail($id);
    $subscribedEvents = $user->subscribedEvents()->paginate(15);

    foreach ($subscribedEvents as $event) {
        $imageUrl = $event->image ? url("storage/images/$event->image") : null;
        $event->image_url = $imageUrl;
    }

    return response()->json(['message' => 'Subscribed events retrieved successfully', 'data' => $subscribedEvents], 200);
}

}
