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


    public function updateUserInfo(Request $request, $id)
    {
        $data = User::findOrFail($id);
        $data->fill($request->all());
    
        // Actualizar la imagen del usuario si se proporciona una nueva imagen
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $imagePath = $image->storeAs('images/users', $imageName, 'public');
            $data->image_path = $imagePath;
        }
    
        $data->save();
    
        // Construir la URL de la imagen
        $imageUrl = $data->image_path ? url("storage/images/users/$data->image_path") : null;
    
        // Agregar la URL de la imagen al objeto de usuario
        $data->image_url = $imageUrl;
    
        // Retornar la respuesta JSON con la URL de la imagen
        return response()->json(['message' => 'User information updated successfully', 'data' => $data], 200);
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
        return response()->json(['message' => 'Subscribed events retrieved successfully', 'data' => $subscribedEvents], 200);
    }

}
