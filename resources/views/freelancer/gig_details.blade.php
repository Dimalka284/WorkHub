@extends('layout.app')

@section('content')
<div class="max-w-6xl px-4 py-12 mx-auto">
    <a href="{{ route('gigs.index') }}" class="inline-block mb-6 text-3xl text-blue-600 hover:underline">
        <img src="{{ asset('images/larrow.png') }}" alt="People" class="w-10 h-10">Back </a>
    <div class="overflow-hidden bg-white shadow-xl rounded-2xl md:flex">
        @if($gig->profileimg)
            <div class="overflow-hidden md:w-1/3 h-80 md:h-auto">
                <img src="{{ asset('storage/' . $gig->profileimg) }}" 
                     alt="{{ $gig->display_name }}" 
                     class="object-cover w-full h-full">
            </div>
        @endif

        {{-- Right: Details --}}
        <div class="flex flex-col justify-between gap-6 p-8 md:w-2/3">

            {{-- Gig Title & Description --}}
            <div>
                <h1 class="mb-3 text-3xl font-bold text-gray-800">{{ $gig->display_name }}</h1>
                <p class="mb-6 text-lg text-gray-600">{{ $gig->description }}</p>
            </div>

            {{-- Freelancer Info --}}
            <div class="p-6 mb-6 shadow-inner bg-gray-50 rounded-xl">
                <h2 class="mb-3 text-xl font-semibold text-gray-700">Freelancer Info</h2>
                <ul class="space-y-2 text-sm text-gray-700">
                    @if($gig->freelancer)
                        <li><strong>Name:</strong> {{ $gig->freelancer->firstName }} {{ $gig->freelancer->lastName }}</li>
                        @if($gig->freelancer->bio)
                            <li><strong>Bio:</strong> {{ $gig->freelancer->bio }}</li>
                        @endif
                        @if($gig->college)
                            <li><strong>College:</strong> {{ $gig->college }}</li>
                        @endif
                        @if($gig->linkedin)
                            <li><strong>LinkedIn:</strong> 
                                <a href="{{ $gig->freelancer->linkedInProfile }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{$gig->freelancer->linkedInProfile }}
                                </a>
                            </li>
                        @endif
                        @if($gig->git)
                            <li><strong>GitHub / Portfolio:</strong> 
                                <a href="{{ $gig->git }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $gig->git }}
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>

            {{-- Skills --}}
            <div>
                <h2 class="mb-3 text-xl font-semibold text-gray-700">Skills & Experience</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($gig->skills as $skill)
                        <span class="px-3 py-1 text-sm text-white transition transform rounded-full shadow bg-gradient-to-r from-sky-500 to-blue-700 hover:scale-105">
                            {{ $skill->name }} ({{ $skill->pivot->experienceLevel }})
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
