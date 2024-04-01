<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Model\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;



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
        $data->save();
        return response()->json(['message' => 'User information updated successfully', 'data' => $data], 200);

    }


    public function updateProfile(Request $request)
    {
        $user = $request->user(); // Obtener el usuario autenticado

        // Preparar las reglas de validación condicionales
        $rules = [
            'name' => 'nullable|string|max:250',
            'email' => 'nullable|string|email:rfc,dns|max:250|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // Validar los datos del formulario de actualización
        $validate = Validator::make($request->all(), $rules);

        // Si la validación falla, devolver un error
        if ($validate->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Validation Error!',
                'data' => $validate->errors(),
            ], 422);
        }

        // Preparar los datos para la actualización
        $userData = [];
        if ($request->has('name')) {
            $userData['name'] = $request->name;
        }
        if ($request->has('email')) {
            $userData['email'] = $request->email;
        }
        if ($request->has('password')) {
            $userData['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images');
            $userData['image'] = $imagePath;
        }

        // Actualizar los campos del usuario con los datos preparados
        if (!empty($userData)) {
            $user->update($userData);
        }

        // Recargar los datos actualizados del usuario después de guardarlos
        $updatedUser = User::findOrFail($user->id);

        // Devolver una respuesta de éxito con los nuevos datos guardados
        return response()->json(['message' => 'User profile updated successfully', 'data' => $updatedUser], 200);
    }





    // public function updateProfile(Request $request)
    // {
    //     try {
    //         $user = $request->user(); // Obtener el usuario autenticado

    //         $validator = Validator::make($request->all(), [
    //             'name' => 'sometimes|string|max:250',
    //             'email' => 'sometimes|string|email:rfc,dns|max:250|unique:users,email,' . $user->id,
    //             'password' => 'nullable|string|min:8|confirmed',
    //             'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json(['message' => 'Validation Error!', 'data' => $validator->errors()], 422);
    //         }

    //         // Usar fill() para asignar los nuevos valores
    //         $user->fill($request->only(['name', 'email']));

    //         Log::info('Request data:', $request->all());
    //         Log::info('User data:', $user->toArray());

    //         // Verificar si hay cambios después de asignar los nuevos valores
    //         if ($user->isDirty()) {
    //             Log::info('User is dirty: ' . ($user->isDirty() ? 'true' : 'false'));

    //             if ($request->has('password')) {
    //                 $user->password = Hash::make($request->password);
    //             }

    //             if ($request->hasFile('image')) {
    //                 $imagePath = $request->file('image')->store('profile_images');
    //                 $user->image = $imagePath;
    //             }

    //             $user->save();
    //             return response()->json(['message' => 'User profile updated successfully', 'data' => $user], 200);
    //         } else {
    //             return response()->json(['message' => 'No changes detected!'], 200);
    //         }
    //     } catch (\Exception $exception) {
    //         // Log the exception
    //         Log::error('Error updating user profile: ' . $exception->getMessage());
    //         // Return error response
    //         return response()->json(['message' => 'Error updating user profile'], 500);
    //     }
    // }



    public function getUserProfile($id)
    {
        // Obtener el perfil del usuario con el ID proporcionado
        $user = User::findOrFail($id);

        // Retornar los datos del perfil del usuario
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