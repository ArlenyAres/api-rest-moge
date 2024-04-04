<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class RegistrationController extends Controller
{
    public function register(Request $request, $eventId)
    {

        // Verifica que el usuario este autenticado
        if (!$request->user()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Verifica si el usuario ya esta registrado en el evento
        $existingRegistration = Registration::where('event_id', $eventId)
        ->where('user_id', Auth::user()->id)
        ->first();

        if ($existingRegistration) {
            return response()->json(['error' => 'User is already registered for this event'], 400);
        }
        // Registra un usuario en un evento
        $registration = new Registration;
        $registration->event_id = $eventId;
        $registration->user_id = Auth::user()->id;
        $registration->save();

        return response()->json($registration, 201);
    }

    public function unregister($eventId)
    {
        // Desregistra un usuario de un evento
        $registration = Registration::where('event_id', $eventId)
            ->where('user_id', auth()->id())
            ->first();
        if ($registration) {
            $registration->delete();
            return response()->json(['message' => 'Unregistered successfully'], 200);
        }
        return response()->json(['error' => 'No se encontró la inscripción'], 404);
    }
}
