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
}