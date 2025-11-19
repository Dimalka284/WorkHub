@extends('layout.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <a href="{{ route('gigs.index') }}" class="text-blue-600 hover:underline mb-6 inline-block text-3xl">
        <img src="{{ asset('images/larrow.png') }}" alt="People" class="w-10 h-10">Back </a>
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden md:flex">
        @if($gig->profileimg)
            <div class="md:w-1/3 h-80 md:h-auto overflow-hidden">
                <img src="{{ asset('storage/' . $gig->profileimg) }}" 
                     alt="{{ $gig->display_name }}" 
                     class="w-full h-full object-cover">
            </div>
        @endif

        {{-- Right: Details --}}
        <div class="md:w-2/3 p-8 flex flex-col justify-between gap-6">

            {{-- Gig Title & Description --}}
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-3">{{ $gig->display_name }}</h1>
                <p class="text-gray-600 text-lg mb-6">{{ $gig->description }}</p>
            </div>

            {{-- Freelancer Info --}}
            <div class="bg-gray-50 p-6 rounded-xl shadow-inner mb-6">
                <h2 class="text-xl font-semibold text-gray-700 mb-3">Freelancer Info</h2>
                <ul class="space-y-2 text-gray-700 text-sm">
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
                                <a href="{{ $gig->linkedin }}" target="_blank" class="text-blue-600 hover:underline">
                                    {{ $gig->linkedin }}
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
                <h2 class="text-xl font-semibold text-gray-700 mb-3">Skills & Experience</h2>
                <div class="flex flex-wrap gap-3">
                    @foreach($gig->skills as $skill)
                        <span class="bg-gradient-to-r from-sky-500 to-blue-700 text-white px-3 py-1 rounded-full text-sm shadow hover:scale-105 transform transition">
                            {{ $skill->name }} ({{ $skill->pivot->experienceLevel }})
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
