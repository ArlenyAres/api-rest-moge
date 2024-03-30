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

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:250',
            'email' => 'string|email:rfc,dns|max:250|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation Error!', 'data' => $validator->errors()], 422);
        }

        // Guardar los datos originales del usuario antes de actualizar
        $originalData = $user->toArray();

        // Usar fill() para asignar los nuevos valores
        $user->fill($request->only(['name', 'email']));

        // Verificar si hay cambios después de asignar los nuevos valores
        if ($user->isDirty()) {
            if ($request->has('password')) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profile_images');
                $user->image = $imagePath;
            }

            $user->save();
            return response()->json(['message' => 'User profile updated successfully', 'data' => $user], 200);
        } else {
            // Comparar los datos originales con los datos actuales
            if ($user->toArray() !== $originalData) {
                $user->save();
                return response()->json(['message' => 'User profile updated successfully', 'data' => $user], 200);
            } else {
                return response()->json(['message' => 'No changes detected!'], 200);
            }
        }

        }

    public function getUserProfile($id)
    {
        // Obtener el perfil del usuario con el ID proporcionado
        $user = User::findOrFail($id);

        // Retornar los datos del perfil del usuario
        return response()->json(['message' => 'User profile retrieved successfully', 'data' => $user], 200);
    }

    // public function updateUserProfile(Request $request, $id)
    // {
    //     // Validar los datos del formulario
    //     $validator = Validator::make($request->all(), [
    //         'name' => 'string|max:250',
    //         'email' => 'string|email|max:250|unique:users,email,' . $id,
    //         'password' => 'nullable|string|min:8|confirmed',
    //     ]);

    //     // Si hay errores de validación, devolverlos como respuesta
    //     if ($validator->fails()) {
    //         return response()->json(['message' => 'Validation Error!', 'data' => $validator->errors()], 422);
    //     }

    //     // Actualizar el perfil del usuario con los datos proporcionados
    //     $user = User::findOrFail($id);
    //     $user->fill($request->all());

    //     // Si se proporcionó una nueva contraseña, cifrarla
    //     if ($request->has('password')) {
    //         $user->password = bcrypt($request->password);
    //     }

    //     // Guardar los cambios en el perfil del usuario
    //     $user->save();

    //     // Retornar la respuesta con el perfil actualizado del usuario
    //     return response()->json(['message' => 'User profile updated successfully', 'data' => $user], 200);
    // }

    public function deleteUser($id)
    {
        // Encontrar y eliminar al usuario con el ID proporcionado
        $user = User::findOrFail($id);
        $user->delete();

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}