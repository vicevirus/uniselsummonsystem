<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SecurityGuard;

class SecurityGuardController extends Controller
{
    /**
     * Show the security guard login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('guard.guardLogin');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validate the form data
        $this->validate($request, [
            'guard_username' => 'required|string',
            'guard_password' => 'required|string',
        ]);
   
  
        // Attempt to log the guard in
        if (Auth::guard('guard')->attempt(['guard_username' => $request->guard_username, 'password' => $request->guard_password])) {
            
            // If successful, then redirect to their intended location
            return redirect()->intended(route('guard.dashboard'));
        }

        // If unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('guard_username', 'remember'));
    }

    /**
     * Log the guard out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::guard('guard')->logout();
        return redirect('/guard/login');
    }

    /**
     * Show the guard's dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        return view('guard.guardDashboard');
    }
}
