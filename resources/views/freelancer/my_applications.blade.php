@extends('layout.app')

@section('title', 'My Applications')

@section('content')

@if(session('success'))
    <div class="fixed top-4 right-4 z-50 px-6 py-4 text-white bg-green-600 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif

<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <div class="flex flex-col items-start justify-between pb-6 mb-8 border-b sm:flex-row sm:items-center">
        <div>
            <h1 class="mb-2 text-4xl font-extrabold tracking-tight text-gray-900">
                My Applications
            </h1>
            <p class="text-lg text-gray-600">Track your {{ $applications->count() }} job applications</p>
        </div>
        
        <a href="{{ route('jobs.browse') }}" 
           class="flex items-center px-6 py-3 mt-4 space-x-2 text-base font-semibold text-white transition duration-200 ease-in-out bg-indigo-600 shadow-lg rounded-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 sm:mt-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span>Browse Jobs</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6">
        @forelse($applications as $application)
            <div class="overflow-hidden transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl">
                <div class="p-6">
                    <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="mb-2 text-2xl font-bold text-gray-900">
                                        {{ $application->jobPost->title }}
                                    </h3>
                                    <div class="flex flex-wrap items-center text-sm text-gray-500 gap-x-4 gap-y-2">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>{{ $application->jobPost->client->firstName ?? 'Client' }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="font-bold text-green-600">Rs.{{ number_format($application->jobPost->budget, 2) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span>Applied {{ $application->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($application->status === 'accepted')
                                    <span class="px-4 py-2 ml-4 text-sm font-semibold text-green-700 bg-green-100 border border-green-200 rounded-full whitespace-nowrap">
                                        ✓ Accepted
                                    </span>
                                @elseif($application->status === 'rejected')
                                    <span class="px-4 py-2 ml-4 text-sm font-semibold text-red-700 bg-red-100 border border-red-200 rounded-full whitespace-nowrap">
                                        ✗ Rejected
                                    </span>
                                @else
                                    <span class="px-4 py-2 ml-4 text-sm font-semibold text-blue-700 bg-blue-100 border border-blue-200 rounded-full whitespace-nowrap">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </div>
                            
                            <div class="p-4 mb-4 border border-gray-200 bg-gray-50 rounded-lg">
                                <h4 class="mb-2 text-sm font-semibold text-gray-700">Your Cover Letter:</h4>
                                <p class="text-sm text-gray-600 line-clamp-3">{{ $application->cover_letter }}</p>
                            </div>
                            
                            @if($application->proposed_rate)
                                <div class="mb-4">
                                    <span class="text-sm text-gray-600">Your Proposed Rate: </span>
                                    <span class="text-sm font-bold text-green-600">Rs.{{ number_format($application->proposed_rate, 2) }}</span>
                                </div>
                            @endif
                            
                            <div class="flex flex-wrap gap-2">
                                @foreach($application->jobPost->skills->take(5) as $skill)
                                    <span class="px-3 py-1 text-xs font-medium text-indigo-700 border border-indigo-200 rounded-full bg-indigo-50">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Work Submission Section for Accepted Applications --}}
                        @if($application->status === 'accepted')
                            <div class="p-4 mt-4 border-2 border-teal-200 bg-teal-50 rounded-lg">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="text-sm font-semibold text-teal-900">Work Status</h4>
                                    <span class="px-3 py-1 text-xs font-medium text-teal-700 bg-teal-100 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $application->work_status)) }}
                                    </span>
                                </div>
                                
                                @if($application->revisions_used > 0)
                                    <p class="mb-2 text-xs text-teal-700">
                                        Revisions Used: {{ $application->revisions_used }}/{{ $application->max_revisions }}
                                    </p>
                                @endif
                                
                                @if($application->work_status === 'revision_requested')
                                    <div class="p-3 mb-3 bg-yellow-50 border border-yellow-200 rounded">
                                        <p class="text-sm font-medium text-yellow-800">⚠️ Revision Requested</p>
                                        <p class="text-xs text-yellow-700 mt-1">Please review the client's feedback and resubmit your work.</p>
                                    </div>
                                @endif
                                
                                @if(in_array($application->work_status, ['not_started', 'revision_requested']))
                                    <form action="{{ route('job.submit.work', $application->id) }}" method="POST" class="mt-3">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block mb-1 text-xs font-medium text-gray-700">Delivery URL (Optional)</label>
                                            <input type="url" name="delivery_url" 
                                                   class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                                   placeholder="https://drive.google.com/...">
                                        </div>
                                        <div class="mb-3">
                                            <label class="block mb-1 text-xs font-medium text-gray-700">Delivery Message *</label>
                                            <textarea name="delivery_message" rows="3" required
                                                      class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent"
                                                      placeholder="Describe what you've completed..."></textarea>
                                        </div>
                                        <button type="submit" class="w-full px-4 py-2 text-sm font-semibold text-white bg-teal-600 rounded-lg hover:bg-teal-700">
                                            Submit Work
                                        </button>
                                    </form>
                                @elseif($application->work_status === 'submitted')
                                    <p class="text-sm text-teal-700">✓ Work submitted. Waiting for client review...</p>
                                @elseif($application->work_status === 'completed')
                                    <p class="text-sm font-semibold text-green-700">🎉 Work Accepted - Job Completed!</p>
                                @endif
                            </div>
                        @endif
                        
                        <div class="flex flex-col gap-2 md:ml-4">
                            <a href="{{ route('client.job.show', $application->jobPost->jobPostId) }}" 
                               class="px-4 py-2 text-sm font-medium text-center text-indigo-600 transition-colors border border-indigo-600 rounded-lg hover:bg-indigo-50 whitespace-nowrap">
                                View Job
                            </a>
                            
                            @if($application->status === 'pending')
                                <form action="{{ route('applications.withdraw', $application->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to withdraw this application?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full px-4 py-2 text-sm font-medium text-red-600 transition-colors border border-red-600 rounded-lg hover:bg-red-50 whitespace-nowrap">
                                        Withdraw
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="py-16 text-center bg-white shadow-lg rounded-xl">
                <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="mb-4 text-xl text-gray-500">You haven't applied to any jobs yet.</p>
                <a href="{{ route('jobs.browse') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                    Browse available jobs →
                </a>
            </div>
        @endforelse
    </div>
</div>

<script>
    // Auto-hide success messages
    setTimeout(() => {
        const alerts = document.querySelectorAll('.fixed.top-4');
        alerts.forEach(alert => alert.remove());
    }, 5000);
</script>

@endsection
