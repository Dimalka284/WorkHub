@extends('layout.app')

@section('title', 'Browse Jobs')

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
    
    <div class="flex flex-col items-start justify-between pb-6 mb-8 border-b sm:flex-row sm:items-center">
        <div>
            <h1 class="mb-2 text-4xl font-extrabold tracking-tight text-gray-900">
                Browse Jobs
            </h1>
            <p class="text-lg text-gray-600">Find your next opportunity from {{ $jobs->count() }} available jobs</p>
        </div>
        
        <a href="{{ route('applications.my') }}" 
           class="flex items-center px-6 py-3 mt-4 space-x-2 text-base font-semibold text-white transition duration-200 ease-in-out bg-indigo-600 shadow-lg rounded-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 sm:mt-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <span>My Applications</span>
        </a>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        @forelse($jobs as $job)
            @php
                $hasApplied = $job->applications->where('freelancer_id', session('freelancerID'))->first();
                $isAccepted = $job->acceptedApplication != null;
            @endphp
            
            <div class="flex flex-col overflow-hidden transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl hover:border-indigo-300">
                
                <div class="flex flex-col flex-1 p-6">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="flex-1 text-xl font-bold text-gray-900 line-clamp-2" title="{{ $job->title }}">
                            {{ $job->title }}
                        </h3>
                        
                        @if($isAccepted)
                            <span class="px-3 py-1 ml-2 text-xs font-semibold text-yellow-700 bg-yellow-100 border border-yellow-200 rounded-full whitespace-nowrap">
                                Filled
                            </span>
                        @elseif($hasApplied)
                            @if($hasApplied->status === 'accepted')
                                <span class="px-3 py-1 ml-2 text-xs font-semibold text-green-700 bg-green-100 border border-green-200 rounded-full whitespace-nowrap">
                                    Accepted
                                </span>
                            @elseif($hasApplied->status === 'rejected')
                                <span class="px-3 py-1 ml-2 text-xs font-semibold text-red-700 bg-red-100 border border-red-200 rounded-full whitespace-nowrap">
                                    Rejected
                                </span>
                            @else
                                <span class="px-3 py-1 ml-2 text-xs font-semibold text-blue-700 bg-blue-100 border border-blue-200 rounded-full whitespace-nowrap">
                                    Applied
                                </span>
                            @endif
                        @endif
                    </div>
                    
                    <div class="flex flex-wrap items-center mb-4 text-sm text-gray-500 gap-x-4 gap-y-2">
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="font-bold text-green-600">Rs.{{ number_format($job->budget, 2) }}</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $job->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <p class="flex-1 mb-4 text-sm leading-relaxed text-gray-600 line-clamp-3">
                        {{ $job->description }}
                    </p>

                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($job->skills->take(4) as $skill)
                            <span class="px-3 py-1 text-xs font-medium text-indigo-700 border border-indigo-200 rounded-full bg-indigo-50 whitespace-nowrap">
                                {{ $skill->name }}
                            </span>
                        @endforeach
                        @if($job->skills->count() > 4)
                            <span class="px-3 py-1 text-xs font-medium text-gray-600 border border-gray-200 rounded-full bg-gray-50">
                                +{{ $job->skills->count() - 4 }} more
                            </span>
                        @endif
                    </div>
                    
                    <div class="flex items-center justify-between pt-4 mt-auto border-t border-gray-100">
                        <div class="text-xs text-gray-500">
                            <span class="font-semibold">{{ $job->category->name ?? 'N/A' }}</span>
                        </div>
                        
                        @if($isAccepted)
                            <button disabled 
                                    class="px-4 py-2 text-sm font-medium text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed">
                                Job Filled
                            </button>
                        @elseif($hasApplied)
                            <a href="{{ route('applications.my') }}" 
                               class="px-4 py-2 text-sm font-medium text-indigo-600 transition-colors border border-indigo-600 rounded-lg hover:bg-indigo-50">
                                View Application
                            </a>
                        @else
                            <button onclick="openApplyModal({{ $job->jobPostId }}, '{{ addslashes($job->title) }}')" 
                                    class="px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                                Apply Now
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="py-16 text-center bg-white shadow-lg rounded-xl">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <p class="mb-4 text-xl text-gray-500">No jobs available at the moment.</p>
                    <p class="text-sm text-gray-400">Check back later for new opportunities!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Application Modal -->
<div id="applyModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="w-full max-w-2xl p-8 mx-4 bg-white shadow-2xl rounded-2xl">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Apply for Job</h2>
            <button onclick="closeApplyModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <p id="modalJobTitle" class="mb-6 text-lg text-gray-600"></p>
        
        <form id="applyForm" method="POST" action="">
            @csrf
            <div class="mb-6">
                <label for="cover_letter" class="block mb-2 text-sm font-semibold text-gray-700">
                    Cover Letter <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="cover_letter" 
                    id="cover_letter" 
                    rows="6"
                    required
                    minlength="50"
                    placeholder="Explain why you're the perfect fit for this job. Highlight your relevant experience and skills..."
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
                <div class="mt-2 text-xs text-gray-500">
                    <span id="charCount">0</span>/1000 characters (minimum 50)
                </div>
            </div>
            
            <div class="mb-6">
                <label for="proposed_rate" class="block mb-2 text-sm font-semibold text-gray-700">
                    Proposed Rate (Optional)
                </label>
                <div class="relative">
                    <span class="absolute text-gray-500 transform -translate-y-1/2 left-3 top-1/2">Rs.</span>
                    <input 
                        type="number" 
                        name="proposed_rate" 
                        id="proposed_rate"
                        step="0.01"
                        min="0"
                        placeholder="0.00"
                        class="w-full p-3 pl-12 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <p class="mt-2 text-xs text-gray-500">Leave blank to use the job's budget</p>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button 
                    type="button" 
                    onclick="closeApplyModal()"
                    class="px-6 py-3 font-semibold text-gray-700 transition-colors border border-gray-300 rounded-lg hover:bg-gray-50">
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="px-6 py-3 font-semibold text-white transition-colors bg-green-600 rounded-lg shadow-md hover:bg-green-700">
                    Submit Application
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('applyModal');
    const applyForm = document.getElementById('applyForm');
    const modalJobTitle = document.getElementById('modalJobTitle');
    const coverLetter = document.getElementById('cover_letter');
    const charCount = document.getElementById('charCount');
    
    function openApplyModal(jobId, jobTitle) {
        applyForm.action = `/jobs/${jobId}/apply`;
        modalJobTitle.textContent = `Applying for: ${jobTitle}`;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeApplyModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        applyForm.reset();
        charCount.textContent = '0';
    }
    
    coverLetter.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
    
    // Close modal on outside click
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeApplyModal();
        }
    });
    
    // Auto-hide success/error messages
    setTimeout(() => {
        const alerts = document.querySelectorAll('.fixed.top-4');
        alerts.forEach(alert => alert.remove());
    }, 5000);
</script>

@endsection
