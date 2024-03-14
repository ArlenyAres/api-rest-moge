<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Model\Event;


class UserController extends Controller
{

    public function getEventsCreatedByUser($id)
    {
        $user = User::findOrFail($id);
        $eventsCreated = $user->events()->paginate(15); //paginacion
        return response()->json(['message' => 'Events created by user retrieved successfully', 'data' => $eventsCreated], 200);
    }

    // public function getEventsCreatedByUser($id)
    // {
    //     $user = User::findOrFail($id);
    //     $eventsCreated = $user->events;
    //     return response()->json(['message' => 'Events created by user retrieved successfully', 'data' => $eventsCreated], 200);
    // }
    

    public function updateUserInfo(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only(['name', 'email', 'password']));
        return response()->json(['message' => 'User information updated successfully', 'data' => $user], 200);
    }

    public function getSubscribedEvents($id)
    {
        $user = User::findOrFail($id);
        $subscribedEvents = $user->events()->get();
        return response()->json(['message' => 'Subscribed events retrieved successfully', 'data' => $subscribedEvents], 200);
    }
}

/* Dentro del UserController, se implementan los metodos para manejar la actualizacions del perfils de usuario, 
la visualiza los eventos creados por el usuario, y la toso l gestin de la infor
del perfil de usuario (nombre, correo, contraseña, imagen)*/ 
