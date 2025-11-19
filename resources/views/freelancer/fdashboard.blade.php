@extends('layout.app')
@section('title','Freelancer Dashboard')
@section('content')

<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <div class="flex flex-col items-start justify-between pb-4 mb-10 border-b sm:flex-row sm:items-center">
        <h1 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-800 sm:text-4xl sm:mb-0">
            Welcome Back, <span class="text-indigo-600">{{ session('freelancerFirstName') }}</span>!
        </h1>
        
        <a href="/gig">
            <button class="flex items-center px-6 py-3 space-x-2 text-base font-semibold text-white transition duration-200 ease-in-out bg-indigo-600 shadow-lg rounded-xl shadow-indigo-200 hover:bg-indigo-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>Create New Gig</span>
            </button>
        </a>
    </div>

    <h2 class="mb-6 text-2xl font-bold text-gray-700">Your Active Gigs</h2>
    
    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    @foreach($gigs as $gig)
        <div class="flex flex-col overflow-hidden transition-all duration-300 bg-white border border-gray-100 shadow-lg rounded-xl hover:shadow-2xl hover:border-indigo-300">
            
            @if($gig->profileimg)
                <div class="w-full h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $gig->profileimg) }}" 
                        alt="{{ $gig->display_name }}" 
                        class="object-cover w-full h-full transition-transform duration-500 ease-in-out transform hover:scale-110">
                </div>
            @else
                <div class="flex items-center justify-center w-full h-48 bg-gray-200">
                    <span class="text-gray-500">No Image Uploaded</span>
                </div>
            @endif

            <div class="flex flex-col flex-1 p-5">
                <h3 class="mb-2 text-xl font-bold text-gray-900 truncate" title="{{ $gig->display_name }}">
                    {{ $gig->display_name }}
                </h3>
                
                <p class="flex-1 mb-4 text-sm leading-relaxed text-gray-500">
                    {{ Str::limit($gig->description, 90) }}
                </p>

                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($gig->skills as $skill)
                        <span class="px-3 py-1 text-xs font-medium text-indigo-700 border border-indigo-200 rounded-full bg-indigo-50 whitespace-nowrap">
                            {{ $skill->name }}
                        </span>
                    @endforeach
                </div>
                
                <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                    <span class="text-xs font-semibold text-gray-400 uppercase">
                        Level: {{ $gig->skills->first()->pivot->experienceLevel ?? 'N/A' }}
                    </span>
                    
                    <a href="{{ route('gig.details', $gig->id) }}" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-indigo-600 rounded-full shadow-md hover:bg-indigo-700">
                        See Profile
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    @if(count($gigs) === 0)
        <div class="py-16 mt-8 text-center bg-white shadow-lg rounded-xl">
            <p class="mb-4 text-xl text-gray-500">You haven't created any gigs yet.</p>
            <a href="/gig" class="font-semibold text-indigo-600 hover:text-indigo-700">
                Click here to get started!
            </a>
        </div>
    @endif

</div>

@endsection()