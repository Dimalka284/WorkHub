<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry;
use App\Models\Client;

class ClientController extends Controller
{
    public function clientregister(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:clients,email',
            'password' => 'required|min:6',
            'industry' => 'nullable|exists:industries,industryId',
        ]);

        Client::create([
            'firstName' => $request->firstname,
            'lastName' => $request->lastname,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'companyName' => $request->companyname,
            'industryId' => $request->industry,
        ]);

        return redirect('/post');
    }


    public function showRegisterForm()
    {
        $industries = Industry::all(); 
        return view('client_ac', compact('industries'));
    }
}
