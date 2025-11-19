@extends('layout.app')
@section('title','Freelancer Dashboard')
@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 border-b pb-4">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-800 tracking-tight mb-4 sm:mb-0">
            Welcome Back, <span class="text-indigo-600">{{ session('freelancerFirstName') }}</span>!
        </h1>
        
        <a href="/gig">
            <button class="flex items-center space-x-2 
                           px-6 py-3 text-base font-semibold 
                           bg-indigo-600 text-white rounded-xl 
                           shadow-lg shadow-indigo-200 
                           hover:bg-indigo-700 hover:shadow-xl 
                           focus:outline-none focus:ring-4 focus:ring-indigo-500 focus:ring-opacity-50 
                           transition duration-200 ease-in-out">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                <span>Create New Gig</span>
            </button>
        </a>
    </div>

    <h2 class="text-2xl font-bold text-gray-700 mb-6">Your Active Gigs</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
    @foreach($gigs as $gig)
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 
                    hover:shadow-2xl hover:border-indigo-300 
                    transition-all duration-300 overflow-hidden flex flex-col">
            
            @if($gig->profileimg)
                <div class="h-48 w-full overflow-hidden">
                    <img src="{{ asset('storage/' . $gig->profileimg) }}" 
                        alt="{{ $gig->display_name }}" 
                        class="w-full h-full object-cover transform hover:scale-110 transition-transform duration-500 ease-in-out">
                </div>
            @else
                <div class="h-48 w-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Image Uploaded</span>
                </div>
            @endif

            <div class="p-5 flex-1 flex flex-col">
                <h3 class="font-bold text-xl text-gray-900 mb-2 truncate" title="{{ $gig->display_name }}">
                    {{ $gig->display_name }}
                </h3>
                
                <p class="text-gray-500 text-sm flex-1 mb-4 leading-relaxed">
                    {{ Str::limit($gig->description, 90) }}
                </p>

                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($gig->skills as $skill)
                        <span class="text-xs px-3 py-1 bg-indigo-50 text-indigo-700 font-medium rounded-full border border-indigo-200 whitespace-nowrap">
                            {{ $skill->name }}
                        </span>
                    @endforeach
                </div>
                
                <div class="mt-auto flex justify-between items-center pt-3 border-t border-gray-100">
                    <span class="text-xs text-gray-400 font-semibold uppercase">
                        Level: {{ $gig->skills->first()->pivot->experienceLevel ?? 'N/A' }}
                    </span>
                    
                    <a href="{{ route('gig.details', $gig->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-full 
                              hover:bg-indigo-700 shadow-md transition-colors">
                        View/Edit
                    </a>
                </div>
            </div>
        </div>
    @endforeach
    </div>

    @if(count($gigs) === 0)
        <div class="text-center py-16 bg-white rounded-xl shadow-lg mt-8">
            <p class="text-xl text-gray-500 mb-4">You haven't created any gigs yet.</p>
            <a href="/gig" class="text-indigo-600 font-semibold hover:text-indigo-700">
                Click here to get started!
            </a>
        </div>
    @endif

</div>

@endsection()