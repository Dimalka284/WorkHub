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
        <div class="sticky p-6 bg-white border border-gray-200 shadow-md rounded-xl top-8">
            <h3 class="mb-4 text-xl font-semibold text-gray-800">Job Action</h3>
            
            <a href="#" class="block w-full px-6 py-3 mb-3 text-lg font-bold text-center text-white transition duration-150 bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                Apply Now
            </a>
            
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


</div>
@endsection