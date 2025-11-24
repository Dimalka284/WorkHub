<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Freelancer;

class FreelancerController extends Controller
{
    public function freelancerregister(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'required|min:6',
        ]);

        $existing = Freelancer::where('email', $request->email)->first();

        if ($existing) {
            return back()->with('error', 'This email is already registered.');
        }

        Freelancer::create([
            'firstName' => $request->firstname,
            'lastName' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'bio' => $request->bio,
        ]);

        return redirect('/fdashboard');
    }
    
}
