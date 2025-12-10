<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gig;

class GigBrowseController extends Controller
{
    /**
     * Display all gigs for clients to browse
     */
    public function index()
    {
        $gigs = Gig::with('skills', 'freelancer')->get();
        return view('client.gigs_browse', compact('gigs'));
    }

    /**
     * Show detailed gig view with order button
     */
    public function show($id)
    {
        $gig = Gig::with('skills', 'freelancer')->findOrFail($id);
        return view('client.gig_detail', compact('gig'));
    }
}
