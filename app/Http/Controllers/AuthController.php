<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AuthController extends Controller
{
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->user();

        $user = User::firstOrCreate([
            'email' => $githubUser->getEmail(),
        ], [
            'name' => $githubUser->getName() ?? $githubUser->getId(),
        ]);

        auth()->login($user);

        return redirect('/');
    }
}

