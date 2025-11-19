<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CLIENT GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */

    public function redirectClient()
    {
        return Socialite::driver('google')
            ->redirectUrl(env('GOOGLE_REDIRECT_CLIENT'))
            ->redirect();
    }

    public function handleGoogleClient()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->redirectUrl(env('GOOGLE_REDIRECT_CLIENT'))
            ->user();

        // Check if user exists
        $user = Client::where('email', $googleUser->email)->first();

        if (!$user) {
            $user = Client::create([
                'firstName' => $googleUser->name,
                'lastName'  => $googleUser->name,
                'email'     => $googleUser->email,
                'client_id' => $googleUser->id,
                'password'  => bcrypt('google_login_' . uniqid())
            ]);
        }

        Auth::guard('client')->login($user);

        return redirect('/dashboard');
    }



    /*
    |--------------------------------------------------------------------------
    | FREELANCER GOOGLE LOGIN
    |--------------------------------------------------------------------------
    */

    public function redirectFreelancer()
    {
        return Socialite::driver('google')
            ->redirectUrl(env('GOOGLE_REDIRECT_FREELANCER'))
            ->redirect();
    }

    public function handleGoogleFreelancer()
    {
        $googleUser = Socialite::driver('google')
            ->stateless()
            ->redirectUrl(env('GOOGLE_REDIRECT_FREELANCER'))
            ->user();

        // Check if user exists
        $user = Freelancer::where('email', $googleUser->email)->first();

        if (!$user) {
            $user = Freelancer::create([
                'firstName' => $googleUser->name,
                'lastName' => $googleUser->name,
                'email'     => $googleUser->email,
                'freelancerId' => $googleUser->id,
                'password'  => bcrypt('google_login_' . uniqid())
            ]);
        }
        session([
            'freelancerID' => $user->freelancerId,
            'freelancerFirstName' => $user->firstName,
            ]);

        return redirect('/fdashboard');
    }
}
