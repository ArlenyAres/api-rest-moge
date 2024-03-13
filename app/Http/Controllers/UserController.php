<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function updateProfile(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json($user, 200);
    }

    public function getEventsCreatedByUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user->events, 200);
    }

    public function updateUserInfo(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'password']));
        return response()->json($user, 200);
    }
}

/* Dentro del UserController, se implementan los metodos para manejar la actualizacions del perfils de usuario, 
la visualiza los eventos creados por el usuario, y la toso l gestin de la infor
del perfil de usuario (nombre, correo, contraseña, imagen)*/ 
