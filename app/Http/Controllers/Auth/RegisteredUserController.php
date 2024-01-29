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
   
        // $request->validate([
        //     'matricNumber' => ['required', 'string', 'max:100', 'unique:students'],
        //     'name' => ['required', 'string', 'max:100'],
        //     'plateNumber' => ['nullable', 'string', 'max:35'],
        //     'address' => ['nullable', 'string'],
        //     'carType' => ['nullable', 'string', 'max:100'],
        //     'icNumber' => ['required', 'string', 'max:30'],
        // ]);

       
        
        $student = Student::create([
            'matricNumber' => $request->matricNumber,
            'icNumber' => $request->icNumber,
            'name' => $request->name,
            'plateNumber' => $request->plateNumber,
            'address' => $request->address,
            'carType' => $request->carType,
            'password' => Hash::make($request->icNumber),
        ]);

        event(new Registered($student));

        return redirect()->route('registration.pending');
        // Auth::login($student);

        // return redirect(RouteServiceProvider::HOME);
    }
}
