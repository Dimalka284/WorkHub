<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobPost;
use App\Models\JobApplication;
use App\Models\Gig;
use App\Notifications\NewJobApplication;
use App\Notifications\JobApplicationAccepted;
use App\Notifications\JobApplicationRejected;
use App\Notifications\JobWorkSubmitted;
use App\Notifications\JobRevisionRequested;
use App\Notifications\JobCompleted;
use App\Models\JobDelivery;

class JobApplicationController extends Controller
{
    /**
     * Browse available jobs for freelancers
     */
    public function browse()
    {
        $jobs = JobPost::with(['category', 'skills', 'client', 'applications', 'acceptedApplication'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('freelancer.jobs_browse', compact('jobs'));
    }

    /**
     * Freelancer applies to a job
     */
    public function apply(Request $request, $jobId)
    {
        $request->validate([
            'cover_letter' => 'required|string|min:50',
            'proposed_rate' => 'nullable|numeric|min:0',
        ]);

        $job = JobPost::findOrFail($jobId);

        // Check if already applied
        $existingApplication = JobApplication::where('job_post_id', $jobId)
            ->where('freelancer_id', session('freelancerID'))
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied to this job.');
        }

        // Check if job is already filled
        if ($job->acceptedApplication) {
            return redirect()->back()->with('error', 'This job has already been filled.');
        }

        $application = JobApplication::create([
            'job_post_id' => $jobId,
            'freelancer_id' => session('freelancerID'),
            'cover_letter' => $request->cover_letter,
            'proposed_rate' => $request->proposed_rate,
            'status' => 'pending'
        ]);

        // Notify Client
        $job->client->notify(new NewJobApplication($application));

        return redirect()->back()->with('success', 'Application submitted successfully!');
    }

    /**
     * Show freelancer's applications
     */
    public function myApplications()
    {
        $applications = JobApplication::with(['jobPost.category', 'jobPost.client', 'jobPost.skills'])
            ->where('freelancer_id', session('freelancerID'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('freelancer.my_applications', compact('applications'));
    }

    /**
     * Withdraw application
     */
    public function withdraw($id)
    {
        $application = JobApplication::findOrFail($id);

        // Check authorization
        if ($application->freelancer_id !== session('freelancerID')) {
            return redirect()->route('applications.my')->with('error', 'Unauthorized action.');
        }

        // Can only withdraw pending applications
        if ($application->status !== 'pending') {
            return redirect()->route('applications.my')->with('error', 'Cannot withdraw this application.');
        }

        $application->delete();

        return redirect()->route('applications.my')->with('success', 'Application withdrawn successfully.');
    }

    /**
     * Client views all applications for a job
     */
    public function viewApplications($jobId)
    {
        $job = JobPost::with(['category', 'skills'])->findOrFail($jobId);

        // Check authorization
        if ($job->client_id !== session('clientID')) {
            return redirect()->route('client.jobboard')->with('error', 'Unauthorized action.');
        }

        $applications = JobApplication::with(['freelancer', 'freelancer.jobApplications'])
            ->where('job_post_id', $jobId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get freelancer gigs for each application
        foreach ($applications as $application) {
            $application->freelancer_gig = Gig::with('skills')
                ->where('freelancer_id', $application->freelancer_id)
                ->first();
        }

        return view('client.job_applications', compact('job', 'applications'));
    }

    /**
     * Client accepts an application
     */
    public function accept($applicationId)
    {
        $application = JobApplication::with('jobPost')->findOrFail($applicationId);

        // Check authorization
        if ($application->jobPost->client_id !== session('clientID')) {
            return redirect()->route('client.jobboard')->with('error', 'Unauthorized action.');
        }

        // Check if job already has an accepted application
        if ($application->jobPost->acceptedApplication) {
            return redirect()->back()->with('error', 'This job already has an accepted freelancer.');
        }

        // Accept this application
        $application->update(['status' => 'accepted']);

        // Reject all other pending applications for this job
        $rejectedApplications = JobApplication::where('job_post_id', $application->job_post_id)
            ->where('id', '!=', $applicationId)
            ->where('status', 'pending')
            ->get();

        foreach ($rejectedApplications as $rejectedApp) {
            $rejectedApp->update(['status' => 'rejected']);
            $rejectedApp->freelancer->notify(new JobApplicationRejected($rejectedApp));
        }

        // Notify Accepted Freelancer
        $application->freelancer->notify(new JobApplicationAccepted($application));

        return redirect()->back()->with('success', 'Application accepted! Other applications have been rejected.');
    }

    /**
     * Client rejects an application
     */
    public function reject($applicationId)
    {
        $application = JobApplication::with('jobPost')->findOrFail($applicationId);

        // Check authorization
        if ($application->jobPost->client_id !== session('clientID')) {
            return redirect()->route('client.jobboard')->with('error', 'Unauthorized action.');
        }

        $application->update(['status' => 'rejected']);
        
        // Notify Rejected Freelancer
        $application->freelancer->notify(new JobApplicationRejected($application));

        return redirect()->back()->with('success', 'Application rejected.');
    }

    /**
     * Freelancer submits work for accepted application
     */
    public function submitWork(Request $request, $applicationId)
    {
        $request->validate([
            'delivery_url' => 'nullable|url',
            'delivery_message' => 'required|string|min:10',
        ]);

        $application = JobApplication::with(['jobPost.client', 'freelancer'])->findOrFail($applicationId);

        // Check authorization
        if ($application->freelancer_id !== session('freelancerID')) {
            return redirect()->route('applications.my')->with('error', 'Unauthorized action.');
        }

        // Check if application is accepted
        if ($application->status !== 'accepted') {
            return redirect()->route('applications.my')->with('error', 'You can only submit work for accepted applications.');
        }

        // Create delivery
        $delivery = JobDelivery::create([
            'job_application_id' => $applicationId,
            'delivery_url' => $request->delivery_url,
            'delivery_message' => $request->delivery_message,
            'revision_number' => $application->revisions_used,
            'status' => 'pending'
        ]);

        // Update application work status
        $application->update(['work_status' => 'submitted']);

        // Notify Client
        $application->jobPost->client->notify(new JobWorkSubmitted($application, $delivery));

        return redirect()->route('applications.my')->with('success', 'Work submitted successfully!');
    }

    /**
     * Client accepts delivery and completes job
     */
    public function acceptDelivery($applicationId)
    {
        $application = JobApplication::with(['jobPost', 'freelancer', 'latestDelivery'])->findOrFail($applicationId);

        // Check authorization
        if ($application->jobPost->client_id !== session('clientID')) {
            return redirect()->route('client.jobboard')->with('error', 'Unauthorized action.');
        }

        // Update delivery status
        if ($application->latestDelivery) {
            $application->latestDelivery->update(['status' => 'accepted']);
        }

        // Mark job as completed
        $application->update(['work_status' => 'completed']);

        // Notify Freelancer
        $application->freelancer->notify(new JobCompleted($application));

        return redirect()->back()->with('success', 'Work accepted! Job completed.');
    }

    /**
     * Client requests revision
     */
    public function requestRevision(Request $request, $applicationId)
    {
        $request->validate([
            'revision_message' => 'required|string|min:10',
        ]);

        $application = JobApplication::with(['jobPost', 'freelancer', 'latestDelivery'])->findOrFail($applicationId);

        // Check authorization
        if ($application->jobPost->client_id !== session('clientID')) {
            return redirect()->route('client.jobboard')->with('error', 'Unauthorized action.');
        }

        // Check revision limit
        if ($application->revisions_used >= $application->max_revisions) {
            return redirect()->back()->with('error', 'Maximum revisions reached. You must accept the delivery.');
        }

        // Update delivery status
        if ($application->latestDelivery) {
            $application->latestDelivery->update(['status' => 'revision_requested']);
        }

        // Increment revisions used and update status
        $application->update([
            'revisions_used' => $application->revisions_used + 1,
            'work_status' => 'revision_requested'
        ]);

        // Notify Freelancer
        $application->freelancer->notify(new JobRevisionRequested($application, $request->revision_message));

        return redirect()->back()->with('success', 'Revision requested successfully.');
    }
}
