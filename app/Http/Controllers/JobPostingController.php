<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Skill;
use App\Models\JobPost;

class JobPostingController extends Controller
{
    /**
     * Show the Job Post form
     */
    public function showCategories()
    {
        $categories = Category::all();
        $skills = Skill::all();
        return view('client.Jobpost', compact('categories', 'skills'));
    }

    public function saveJob(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|exists:categories,categoryId',
            'scope' => 'required|string',
            'selectedskillsdata' => 'required|string',
            'budget' => 'required|numeric',
            'paymenttype' => 'required|string',
        ]);

        // Create the job post
        $job = JobPost::create([
            'client_id' => session('clientID'),
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'project_length' => $request->scope,
            'budget' => $request->budget,
            'payment_preference' => $request->paymenttype,
            'deadline' => $request->deadline,
        ]);

        // Attach selected skills
        $skills = explode(',', $request->selectedskillsdata);
        foreach ($skills as $skillName) {
            $skill = Skill::where('name', trim($skillName))->first();
            if ($skill) {
                $job->skills()->attach($skill->skillId);
            }
        }

        return redirect('/dashboard')->with('success', 'Job Posted Successfully!');
    }

    public function index()
    {
        $jobs = JobPost::orderBy('created_at', 'desc')->get();
        return view('client.Jobpost', compact('jobs'));
    }

    public function delete($id)
    {
        $job = JobPost::findOrFail($id);
        if ($job->client_id != session('clientID')) {
            abort(403, 'Unauthorized Action.');
        }
        $job->delete();
        return redirect('/dashboard')->with('success', 'Job deleted successfully.');
    }

    public function edit($id)
    {
        $job = JobPost::findOrFail($id);

            if ($job->client_id != session('clientID')) {
                abort(403, 'Unauthorized action.');
            }

            // Load categories and skills for dropdowns
            $categories = Category::all();
            $skills = Skill::all();

            return view('client.editJob', compact('job', 'categories', 'skills'));
    }

    public function update(Request $request, $id)
    {
        $job = JobPost::findOrFail($id);

        if ($job->client_id != session('clientID')) {
            abort(403, 'Unauthorized action.');
        }

        $job->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category,
            'budget' => $request->budget,
        ]);

        // Update skills
        $job->skills()->sync($request->skills);

        return redirect('/dashboard')->with('success', 'Job updated successfully!');
    }


}
