<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {

        $messages = [
            'phoneNumber.regex' => 'The phone number must start with 60',
        ];

        $request->validate([
            'phoneNumber' => ['required', 'string', 'regex:/^60.*$/i'], // Ensure phone number starts with 60
        ], $messages);


        $student = Student::create([
            'matricNumber' => $request->matricNumber,
            'icNumber' => $request->icNumber,
            'name' => $request->name,
            'plateNumber' => $request->plateNumber,
            'phoneNumber' => $request->phoneNumber,
            'address' => $request->address,
            'carType' => $request->carType,
            'password' => Hash::make($request->icNumber),
        ]);

        event(new Registered($student));

        return redirect()->route('registration.pending');
    }
}
