@extends('layout.app')

@section('title', $job->title)

@section('content')
<div class="p-4 mx-auto max-w-7xl sm:p-6 lg:p-8">
<div class="grid grid-cols-1 lg:grid-cols-[2fr_1fr] gap-6">
    <div class="space-y-6">
        <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
            <div class="flex flex-col mb-4 md:flex-row md:justify-between md:items-start">
                <h1 class="text-3xl font-extrabold leading-snug text-gray-900">{{ $job->title }}</h1>
            </div>
            <div class="flex flex-wrap items-center pt-4 mt-4 text-sm text-gray-600 border-t gap-x-6 gap-y-2">
                
                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium text-gray-800">Budget:</span> <span class="font-bold text-green-600">Rs.{{ $job->budget }}</span>
                </div>

                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a1.97 1.97 0 001.765 2.518h11.969a1.97 1.97 0 001.765-2.518l-3-9m-3.5 0a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0z"></path></svg>
                    <span class="font-medium text-gray-800">Payment:</span> {{ $job->paymenttype }}
                </div>

                <div class="flex items-center space-x-1">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h8m-10 0h12a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2z"></path></svg>
                    <span class="font-medium text-gray-800">Posted:</span> {{ $job->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        
        <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
            <h2 class="pb-2 mb-4 text-2xl font-bold text-gray-800 border-b">Job Description</h2>
            <div class="leading-relaxed prose text-gray-700 max-w-none">
                <p>{{ $job->description }}</p>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
            <h2 class="pb-2 mb-4 text-2xl font-bold text-gray-800 border-b">Skills Required</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($job->skills as $skill)
                    <span class="px-4 py-1.5 text-sm font-semibold text-indigo-700 bg-indigo-100 rounded-full hover:bg-indigo-200 transition duration-150">
                        {{ $skill->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    <div class="space-y-6">
        <div class="p-6 bg-white border border-gray-200 shadow-md  rounded-xl top-8">
            <h3 class="mb-4 text-xl font-semibold text-gray-800">Job Action</h3>
            
            @if(session('freelancerID'))
                @php
                    $hasApplied = $job->applications()->where('freelancer_id', session('freelancerID'))->first();
                    $isAccepted = $job->acceptedApplication != null;
                @endphp
                
                @if($isAccepted)
                    <div class="p-4 mb-3 border border-yellow-200 bg-yellow-50 rounded-lg">
                        <p class="text-sm font-semibold text-yellow-800">This job has been filled</p>
                    </div>
                @elseif($hasApplied)
                    @if($hasApplied->status === 'accepted')
                        <div class="p-4 mb-3 border border-green-200 bg-green-50 rounded-lg">
                            <p class="text-sm font-semibold text-green-800">✓ Your application was accepted!</p>
                        </div>
                    @elseif($hasApplied->status === 'rejected')
                        <div class="p-4 mb-3 border border-red-200 bg-red-50 rounded-lg">
                            <p class="text-sm font-semibold text-red-800">Your application was not selected</p>
                        </div>
                    @else
                        <div class="p-4 mb-3 border border-blue-200 bg-blue-50 rounded-lg">
                            <p class="text-sm font-semibold text-blue-800">Application pending review</p>
                        </div>
                    @endif
                    <a href="{{ route('applications.my') }}" class="block w-full px-6 py-3 text-sm font-semibold text-center text-blue-600 transition duration-150 border border-blue-600 rounded-lg hover:bg-blue-50">
                        View My Applications
                    </a>
                @else
                    <button onclick="document.getElementById('applyModal').classList.remove('hidden')" 
                            class="block w-full px-6 py-3 mb-3 text-lg font-bold text-center text-white transition duration-150 bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                        Apply Now
                    </button>
                @endif
            @elseif(session('clientID') == $job->client_id)
                <a href="{{ route('job.applications', $job->jobPostId) }}" 
                   class="block w-full px-6 py-3 mb-3 text-lg font-bold text-center text-white transition duration-150 bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50">
                    View Applications ({{ $job->applications()->count() }})
                </a>
            @else
                <a href="{{ route('login') }}" class="block w-full px-6 py-3 mb-3 text-lg font-bold text-center text-white transition duration-150 bg-green-600 rounded-lg hover:bg-green-700">
                    Login to Apply
                </a>
            @endif
            
            <a href="{{ route('client.jobboard') }}" class="block w-full px-6 py-3 text-sm font-semibold text-center text-blue-600 transition duration-150 border border-blue-600 rounded-lg hover:bg-blue-50">
                Back to Job Board
            </a>
        </div>
        <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
            <h3 class="mb-4 text-xl font-semibold text-gray-800">About the Client</h3>
            <ul class="space-y-3 text-sm text-gray-700">
                <li class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>{{ $job->client->firstName }} (Hiring Manager)</span>
                </li>
                <li class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Category: {{ $job->category->name ?? 'N/A' }}</span>
                </li>
                <li class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Project Length: {{ $job->project_length }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- edit and delete --}}

@if(session('clientID') == $job->client_id)
<div class="flex mt-6 space-x-4">
    <!-- Edit Button -->
    <a href="{{ route('client.job.edit', $job->jobPostId) }}"
       class="flex-1 px-5 py-3 font-semibold text-center text-white transition duration-200 bg-blue-600 shadow-md rounded-2xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <svg class="inline w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
        </svg>
        Edit
    </a>

    <!-- Delete Button -->
    <form action="{{ route('client.job.delete', $job->jobPostId) }}" method="POST" class="flex-1">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="flex w-full px-5 py-3 font-semibold text-white transition duration-200 bg-red-600 shadow-md rounded-2xl hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                onclick="return confirm('Are you sure you want to delete this job post?')">
            <svg class="inline w-5 h-5 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M10 3h4a2 2 0 012 2v2H8V5a2 2 0 012-2z"/>
            </svg>
            Delete
        </button>
    </form>
</div>
@endif


</div>

<!-- Application Modal -->
@if(session('freelancerID'))
<div id="applyModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="w-full max-w-2xl p-8 mx-4 bg-white shadow-2xl rounded-2xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Apply for Job</h2>
            <button onclick="document.getElementById('applyModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <p class="mb-6 text-lg text-gray-600">Applying for: {{ $job->title }}</p>
        
        <form method="POST" action="{{ route('jobs.apply', $job->jobPostId) }}">
            @csrf
            <div class="mb-6">
                <label for="cover_letter" class="block mb-2 text-sm font-semibold text-gray-700">
                    Cover Letter <span class="text-red-500">*</span>
                </label>
                <textarea name="cover_letter" id="cover_letter" rows="6" required minlength="50"
                    placeholder="Explain why you're the perfect fit for this job..."
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
                <div class="mt-2 text-xs text-gray-500">Minimum 50 characters</div>
            </div>
            
            <div class="mb-6">
                <label for="proposed_rate" class="block mb-2 text-sm font-semibold text-gray-700">
                    Proposed Rate (Optional)
                </label>
                <div class="relative">
                    <span class="absolute text-gray-500 transform -translate-y-1/2 left-3 top-1/2">Rs.</span>
                    <input type="number" name="proposed_rate" id="proposed_rate" step="0.01" min="0" placeholder="0.00"
                        class="w-full p-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="document.getElementById('applyModal').classList.add('hidden')"
                    class="px-6 py-3 font-semibold text-gray-700 transition-colors border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-3 font-semibold text-white transition-colors bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection