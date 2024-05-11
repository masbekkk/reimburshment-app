<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'number', 'max:16', 'unique:'.User::class],
            'job_title' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:finance,staff',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'job_title' => $request->job_title,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));
        $user->syncRoles($request->role);
        return response()->json([
            'status' => 'success',
            'message' => 'Data Stored Successfully!', 
            'data' => $user,
        ], Response::HTTP_CREATED);
        // Auth::login($user);

        // return response()->noContent();
    }
}
