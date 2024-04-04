<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthLoginRegisterController extends Controller
{
    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Procesar la imagen y crear el usuario
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $imagePath = $image->storeAs('images/users', $imageName, 'public');
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'password_confirmation' => Hash::make($request->password_confirmation),
                'image_path' => $imagePath,
            ]);

            $user->save();

            // Construir la URL de la imagen del usuario
            $imageUrl = url("storage/images/users/$imageName");

            // Generar token de acceso
            $data['token'] = $user->createToken($request->email)->plainTextToken;
            $data['user'] = $user;

            // Respuesta exitosa
            $response = [
                'status' => 'success',
                'message' => 'User is created successfully.',
                'data' => $data,
                'image_url' => $imageUrl, // Agregar la URL de la imagen al objeto de respuesta
            ];

            return response()->json($response, 201);
        } catch (\Exception $e) {
            // Manejar el error
            Log::error('Error during user registration: ' . $e->getMessage());
            return response()->json(['error' => 'Error during user registration'], 500);
        }
    }

    /**
     * Authenticate the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Implementación de la función de inicio de sesión...
    }

    /**
     * Log out the user from application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Implementación de la función de cierre de sesión...
    }
}
