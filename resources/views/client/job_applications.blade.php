@extends('layout.app')

@section('title', 'Job Applications')

@section('content')

@if(session('success'))
    <div class="fixed top-4 right-4 z-50 px-6 py-4 text-white bg-green-600 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="fixed top-4 right-4 z-50 px-6 py-4 text-white bg-red-600 rounded-lg shadow-lg">
        {{ session('error') }}
    </div>
@endif

<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <div class="pb-6 mb-8 border-b">
        <a href="{{ route('client.job.show', $job->jobPostId) }}" class="inline-flex items-center mb-4 text-indigo-600 hover:text-indigo-700">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Job Details
        </a>
        
        <h1 class="mb-2 text-4xl font-extrabold tracking-tight text-gray-900">
            Applications for: {{ $job->title }}
        </h1>
        <p class="text-lg text-gray-600">{{ $applications->count() }} {{ Str::plural('application', $applications->count()) }} received</p>
    </div>

    @if($job->acceptedApplication)
        <div class="p-6 mb-8 border border-green-200 shadow-lg bg-green-50 rounded-xl">
            <div class="flex items-center mb-2">
                <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-xl font-bold text-green-800">Freelancer Selected</h3>
            </div>
            <p class="text-green-700">You have accepted {{ $job->acceptedApplication->freelancer->firstName }}'s application for this job.</p>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        @forelse($applications as $application)
            <div class="overflow-hidden transition-all duration-300 bg-white border shadow-lg rounded-xl hover:shadow-2xl
                {{ $application->status === 'accepted' ? 'border-green-300 bg-green-50' : ($application->status === 'rejected' ? 'border-gray-200 opacity-75' : 'border-indigo-200') }}">
                
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-start space-x-4">
                            @if($application->freelancer_gig && $application->freelancer_gig->profileimg)
                                <img src="{{ asset('storage/' . $application->freelancer_gig->profileimg) }}" 
                                     alt="{{ $application->freelancer->firstName }}"
                                     class="object-cover w-16 h-16 border-2 border-indigo-200 rounded-full">
                            @else
                                <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-white bg-indigo-600 rounded-full">
                                    {{ substr($application->freelancer->firstName, 0, 1) }}
                                </div>
                            @endif
                            
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">
                                    {{ $application->freelancer->firstName }} {{ $application->freelancer->lastName }}
                                </h3>
                                @if($application->freelancer_gig)
                                    <p class="text-sm text-gray-600">{{ $application->freelancer_gig->display_name }}</p>
                                @endif
                                <p class="text-xs text-gray-500">Applied {{ $application->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        
                        @if($application->status === 'accepted')
                            <span class="px-4 py-2 text-sm font-semibold text-green-700 bg-green-100 border border-green-300 rounded-full">
                                ✓ Accepted
                            </span>
                        @elseif($application->status === 'rejected')
                            <span class="px-4 py-2 text-sm font-semibold text-red-700 bg-red-100 border border-red-300 rounded-full">
                                ✗ Rejected
                            </span>
                        @else
                            <span class="px-4 py-2 text-sm font-semibold text-blue-700 bg-blue-100 border border-blue-300 rounded-full">
                                ⏳ Pending
                            </span>
                        @endif
                    </div>
                    
                    <div class="p-4 mb-4 border border-gray-200 bg-gray-50 rounded-lg">
                        <h4 class="mb-2 text-sm font-semibold text-gray-700">Cover Letter:</h4>
                        <p class="text-sm text-gray-600">{{ $application->cover_letter }}</p>
                    </div>
                    
                    @if($application->proposed_rate)
                        <div class="flex items-center mb-4 space-x-2">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-600">Proposed Rate:</span>
                            <span class="text-sm font-bold text-green-600">Rs.{{ number_format($application->proposed_rate, 2) }}</span>
                        </div>
                    @endif
                    
                    @if($application->freelancer_gig && $application->freelancer_gig->skills->count() > 0)
                        <div class="mb-4">
                            <h4 class="mb-2 text-sm font-semibold text-gray-700">Skills:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($application->freelancer_gig->skills->take(5) as $skill)
                                    <span class="px-3 py-1 text-xs font-medium text-indigo-700 border border-indigo-200 rounded-full bg-indigo-50">
                                        {{ $skill->name }} ({{ $skill->pivot->experienceLevel }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    {{-- Work Delivery Review Section for Accepted Applications --}}
                    @if($application->status === 'accepted')
                        <div class="p-4 mb-4 border-2 border-teal-200 bg-teal-50 rounded-lg">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-semibold text-teal-900">Work Progress</h4>
                                <span class="px-3 py-1 text-xs font-medium text-teal-700 bg-teal-100 rounded-full">
                                    {{ ucfirst(str_replace('_', ' ', $application->work_status)) }}
                                </span>
                            </div>
                            
                            <p class="mb-2 text-xs text-teal-700">
                                Revisions: {{ $application->revisions_used }}/{{ $application->max_revisions }}
                            </p>
                            
                            @if($application->work_status === 'submitted' && $application->latestDelivery)
                                <div class="p-4 mt-3 bg-white border border-teal-200 rounded-lg">
                                    <h5 class="mb-2 text-sm font-semibold text-gray-800">📦 Submitted Work</h5>
                                    <p class="mb-2 text-sm text-gray-700">{{ $application->latestDelivery->delivery_message }}</p>
                                    
                                    @if($application->latestDelivery->delivery_url)
                                        <a href="{{ $application->latestDelivery->delivery_url }}" target="_blank" 
                                           class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-700">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                            View Delivery
                                        </a>
                                    @endif
                                    
                                    <div class="flex gap-2 mt-4">
                                        <form action="{{ route('job.accept.delivery', $application->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            <button type="submit" 
                                                    onclick="return confirm('Accept this work and complete the job?')"
                                                    class="w-full px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700">
                                                ✓ Accept Work
                                            </button>
                                        </form>
                                        
                                        @if($application->revisions_used < $application->max_revisions)
                                            <button onclick="showRevisionModal({{ $application->id }})" 
                                                    class="flex-1 px-4 py-2 text-sm font-semibold text-orange-600 bg-white border border-orange-600 rounded-lg hover:bg-orange-50">
                                                🔄 Request Revision ({{ $application->max_revisions - $application->revisions_used }} left)
                                            </button>
                                        @else
                                            <button disabled 
                                                    class="flex-1 px-4 py-2 text-sm font-semibold text-gray-400 bg-gray-100 border border-gray-300 rounded-lg cursor-not-allowed">
                                                No Revisions Left
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @elseif($application->work_status === 'not_started')
                                <p class="text-sm text-gray-600">⏳ Waiting for freelancer to start work...</p>
                            @elseif($application->work_status === 'revision_requested')
                                <p class="text-sm text-orange-600">🔄 Revision requested. Waiting for resubmission...</p>
                            @elseif($application->work_status === 'completed')
                                <p class="text-sm font-semibold text-green-700">✅ Work Accepted - Job Completed!</p>
                            @endif
                        </div>
                    @endif
                    
                    <div class="flex gap-2 pt-4 mt-4 border-t border-gray-200">
                        @if($application->freelancer_gig)
                            <a href="{{ route('gig.details', $application->freelancer_gig->id) }}" 
                               class="flex-1 px-4 py-2 text-sm font-medium text-center text-indigo-600 transition-colors border border-indigo-600 rounded-lg hover:bg-indigo-50">
                                View Profile
                            </a>
                        @endif
                        
                        @if($application->status === 'pending' && !$job->acceptedApplication)
                            <form action="{{ route('application.accept', $application->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Accept this application? Other applications will be rejected.')"
                                        class="w-full px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                                    Accept
                                </button>
                            </form>
                            
                            <form action="{{ route('application.reject', $application->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" 
                                        onclick="return confirm('Reject this application?')"
                                        class="w-full px-4 py-2 text-sm font-medium text-red-600 transition-colors border border-red-600 rounded-lg hover:bg-red-50">
                                    Reject
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="py-16 text-center bg-white shadow-lg rounded-xl">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="mb-4 text-xl text-gray-500">No applications yet.</p>
                    <p class="text-sm text-gray-400">Check back later as freelancers apply to your job!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Revision Request Modal --}}
<div id="revisionModal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" onclick="closeRevisionModal()"></div>
        
        <div class="relative z-10 w-full max-w-md p-6 bg-white rounded-lg shadow-xl">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Request Revision</h3>
            
            <form id="revisionForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Revision Message *</label>
                    <textarea name="revision_message" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                              placeholder="Explain what needs to be changed..."></textarea>
                </div>
                
                <div class="flex gap-2">
                    <button type="button" onclick="closeRevisionModal()" 
                            class="flex-1 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 text-sm font-medium text-white bg-orange-600 rounded-lg hover:bg-orange-700">
                        Send Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-hide success/error messages
    setTimeout(() => {
        const alerts = document.querySelectorAll('.fixed.top-4');
        alerts.forEach(alert => alert.remove());
    }, 5000);
    
    function showRevisionModal(applicationId) {
        const modal = document.getElementById('revisionModal');
        const form = document.getElementById('revisionForm');
        form.action = `/job-applications/${applicationId}/request-revision`;
        modal.classList.remove('hidden');
    }
    
    function closeRevisionModal() {
        const modal = document.getElementById('revisionModal');
        modal.classList.add('hidden');
    }

</script>

@endsection
