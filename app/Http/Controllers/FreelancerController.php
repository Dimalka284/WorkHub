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
            'email' => 'required|email|unique:freelancer,email',
            'password' => 'required|min:6',
        ]);

        Freelancer::create([
            'firstName' => $request->firstname,
            'lastName' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'bio' => $request->bio,
        ]);

        return back()->with('message', 'Registered Successfully');
    }

}
