<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
   public function store(Request $request): RedirectResponse
{
    // Validate request
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'age' => ['required', 'integer', 'min:1'],
        'gender' => ['required', 'string', 'in:male,female,other'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Create user
    $user = User::create([
        'name' => $request->name,
        'age' => $request->age,
        'gender' => $request->gender,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'user_type' => 'user',
    ]);

    // Fire registered event
    event(new Registered($user));

    // Log the user in
    Auth::login($user);

    return redirect()->route('dashboard');
}
}
