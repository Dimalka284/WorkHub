<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Freelancer;

use Illuminate\Http\Request;

class FreelancerProfileController extends Controller
{
    public function edit() {
        $freelancer = Freelancer::find(session('freelancerID'));
        return view('freelancer.profile', compact('freelancer'));
    }

    public function update(Request $request) {
        $freelancer = Freelancer::find(session('freelancerID'));

        $request->validate([
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'required|email',
            'bio'       => 'required|min:10',
        ]);

        $freelancer->update($request->all());

        return back()->with('success', 'Profile updated successfully!');
    }
}
