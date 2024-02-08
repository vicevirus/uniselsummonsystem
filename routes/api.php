<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SummonController;

Route::post('/guard/login', function (Request $request) {
    $credentials = $request->only('guard_username', 'password');

    if (Auth::guard('guard')->attempt(['guard_username' => $credentials['guard_username'], 'password' => $credentials['password']])) {
        $user = Auth::guard('guard')->user(); // Get the authenticated user

        // Generate a random token and hash it for API token
        $token = Str::random(60);
        $user->api_token = hash('sha256', $token);

        // Update the user's API token
        if (!$user->save()) {
            return response()->json(['error' => 'Failed to update user token.'], 500);
        }

        // Return token and securityName in the response
        return response()->json([
            'token' => $token,
            'securityName' => $user->securityName,
            'securityId' => $user->securityId // Assuming 'securityName' is a property of the authenticated user
        ]);
    }

    return response()->json(['error' => 'Unauthorized'], 401);
});


Route::post('/guard/createSummon', [SummonController::class, 'createSummon']);
