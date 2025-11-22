<?php

namespace App\Http\Controllers;
use App\Models\Client;
use App\Models\Industry;

use Illuminate\Http\Request;

class ClientProfileController extends Controller
{
    public function edit()
    {
        $clientId = session('clientID');  // logged-in client

        $client = Client::find($clientId);

        // Load industries table
        $industries = Industry::all();

        return view('client.profile', [
            'client' => $client,
            'industries' => $industries
        ]);
    }

    public function update(Request $request) {
        $client = Client::find(session('clientID'));

        $request->validate([
            'firstName' => 'required',
            'lastName'  => 'required',
            'email'     => 'required|email',
            'companyName' => 'required',
        ]);

        $client->update($request->all());

        return back()->with('success', 'Profile updated successfully!');
    }
}
