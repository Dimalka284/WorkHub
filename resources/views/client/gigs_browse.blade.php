@extends('layout.app')

@section('title', 'Browse Gigs')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <div class="flex flex-col items-start justify-between pb-4 mb-10 border-b sm:flex-row sm:items-center">
        <div>
            <h1 class="mb-2 text-3xl font-extrabold tracking-tight text-gray-800 sm:text-4xl">
                Browse Gigs
            </h1>
            <p class="text-gray-600">Find talented freelancers and their services</p>
        </div>
    </div>

    @if($gigs->count() > 0)
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
                        <div class="flex items-center justify-center w-full h-48 bg-gradient-to-br from-indigo-100 to-purple-100">
                            <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif

                    <div class="flex flex-col flex-1 p-5">
                        <h3 class="mb-2 text-xl font-bold text-gray-900 truncate" title="{{ $gig->display_name }}">
                            {{ $gig->display_name }}
                        </h3>
                        
                        @if($gig->freelancer)
                            <p class="mb-3 text-sm text-gray-500">
                                by {{ $gig->freelancer->firstName }} {{ $gig->freelancer->lastName }}
                            </p>
                        @endif
                        
                        <p class="flex-1 mb-4 text-sm leading-relaxed text-gray-500">
                            {{ Str::limit($gig->description, 90) }}
                        </p>

                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($gig->skills->take(3) as $skill)
                                <span class="px-3 py-1 text-xs font-medium text-indigo-700 border border-indigo-200 rounded-full bg-indigo-50 whitespace-nowrap">
                                    {{ $skill->name }}
                                </span>
                            @endforeach
                            @if($gig->skills->count() > 3)
                                <span class="px-3 py-1 text-xs font-medium text-gray-500 border border-gray-200 rounded-full bg-gray-50">
                                    +{{ $gig->skills->count() - 3 }} more
                                </span>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between pt-3 mt-auto border-t border-gray-100">
                            <span class="text-xs font-semibold text-gray-400 uppercase">
                                Level: {{ $gig->skills->first()->pivot->experienceLevel ?? 'N/A' }}
                            </span>
                            
                            <a href="{{ route('gigs.show', $gig->id) }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-white transition-colors bg-green-600 rounded-full shadow-md hover:bg-green-700">
                                See More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-16 mt-8 text-center bg-white shadow-lg rounded-xl">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="mb-4 text-xl text-gray-500">No gigs available at the moment.</p>
            <p class="text-gray-400">Check back later for new freelancer services!</p>
        </div>
    @endif

</div>
@endsection
