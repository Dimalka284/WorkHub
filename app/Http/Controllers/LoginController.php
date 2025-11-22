<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use App\Models\Freelancer;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Try to log in as client
        if (Auth::guard('client')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
             $client = Auth::guard('client')->user();
             session([
                'clientID' => $client->clientId,
                'clientFirstName' => $client->firstName
            ]);
            return redirect('/dashboard'); //nav to the post
        }

        // Try to log in as freelancer
            if (Auth::guard('freelancer')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $freelancer = Auth::guard('freelancer')->user();
            session([
                'freelancerID' => $freelancer->freelancerId, 
                'freelancerFirstName' => $freelancer->firstName, 
            ]);
            return redirect('/fdashboard'); 
        }

        // If none match
        return back()->withErrors(['loginError' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        if (Auth::guard('client')->check()) {
            Auth::guard('client')->logout();
        }

        if (Auth::guard('freelancer')->check()) {
            Auth::guard('freelancer')->logout();
        }

         // Clear all session data
        Session::flush();
        return redirect('/');
    }
}

