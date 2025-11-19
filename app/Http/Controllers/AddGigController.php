<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\gig;


class AddGigController extends Controller
{
     public function getallskills()
    {
        $skills = Skill::all();
        return view('freelancer.gig', compact('skills'));
    }

    public function store(Request $request)
    {
    // Decode skills JSON first
    $request->merge(['skills' => json_decode($request->skills, true)]);

    $request->validate([
        'displayname' => 'required|string|max:255',
        'profileimg' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'description' => 'required|string|min:150',
        'college' => 'nullable|string|max:255',
        'linkedin' => 'nullable|url|max:255',
        'git' => 'nullable|url|max:255',
        'skills' => 'required|array|min:1',
        'skills.*.id' => 'required|exists:skills,skillId',
        'skills.*.level' => 'required|string|in:Beginner,Intermediate,Expert',
    ]);

    $profileImgPath = null;
    if ($request->hasFile('profileimg')) {
        $profileImgPath = $request->file('profileimg')->store('profile_images', 'public');
    }

    $gig = Gig::create([
        'freelancer_id' => session('freelancerID'),
        'display_name' => $request->displayname,
        'profileimg' => $profileImgPath,
        'description' => $request->description,
        'college' => $request->college,
        'linkedin' => $request->linkedin,
        'git' => $request->git,
    ]);

    foreach ($request->skills as $skill) {
        $gig->skills()->attach($skill['id'], ['experienceLevel' => $skill['level']]);
    }

    return redirect('/fdashboard')->with('success', 'Gig created successfully!');
    }

    public function index()
    {
        $gigs = Gig::with('skills')->get();
        return view('freelancer.fdashboard', compact('gigs'));
    }

    // Show details of a single gig
    public function details($id)
    {
        $gig = Gig::with('skills', 'freelancer')->findOrFail($id);
        return view('freelancer.gig_details', compact('gig'));
    }
}
