<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;

class ClientJobController extends Controller
{
    public function index()
    {
        $jobs = JobPost::with('category', 'skills') // eager load relationships
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('client.dashboard', compact('jobs'));
    }

    public function show($id)
    {
        $job = JobPost::with('category', 'skills')->findOrFail($id);
        return view('client.dashboard', compact('job'));
    }
    
    public function showdetails($id)
    {
        $job = JobPost::with('category', 'skills', 'client')->findOrFail($id);
        return view('client.Jobdetails', compact('job'));
    }
}

