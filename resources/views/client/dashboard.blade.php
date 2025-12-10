@extends('layout.app')

@section('title','dashboard')
@section('content')
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

<div class="flex justify-end">  
    <a href="/post"><button 
    class="px-6 py-2 text-lg font-semibold text-white transition duration-150 ease-in-out bg-blue-600 shadow-md rounded-xl hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:bg-blue-800">
    Post a Job
</button></a>
</div>
<div class="grid grid-cols-1 gap-6 p-6 md:grid-cols-2 lg:grid-cols-3">
    @foreach($jobs as $job)
    <div class="relative flex flex-col p-6 transition-shadow duration-300 bg-white border border-gray-200 shadow-md rounded-2xl hover:shadow-xl">
        <div class="absolute flex space-x-2 top-4 right-4">
            <span class="px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full">New</span>
            @if($job->applications()->count() > 0)
                <span class="px-3 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">
                    {{ $job->applications()->count() }} {{ Str::plural('Applicant', $job->applications()->count()) }}
                </span>
            @endif
        </div>
        <h2 class="mb-2 text-xl font-bold text-gray-900">{{ $job->title }}</h2>
        <div class="flex flex-wrap items-center mb-4 text-sm text-gray-500">
            <span class="mr-2">{{ $job->paymenttype }}</span>
            <span class="mr-2">•</span>
            <span>Posted {{ $job->created_at->diffForHumans() }}</span>
        </div>
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach($job->skills as $skill)
                <span class="px-3 py-2 text-lg font-medium text-white bg-indigo-500 rounded-full">
                    {{ $skill->name }}
                </span>
            @endforeach
        </div>
        <p class="mb-6 text-gray-700">{{ Str::limit($job->description, 120) }}</p>
        <a href="{{ route('client.job.show', $job->jobPostId) }}">
        <button class="self-start px-6 py-2 text-white transition-colors duration-200 bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
            See more
        </button></a>
    </div>
    @endforeach
</div>


<div class="container px-4 py-8 mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Industries in High Demand for Expert Consultations</h2>
    </div>

    <div id="expert-categories-page-1" class="relative grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/tourism.png') }}" alt="tourism" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Hospitality & Tourism</h3>
        </div>

        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/transp.png') }}"  alt="logo icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Transportation & Logistics</h3>
        </div>

        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/musical.png') }}" alt="writing" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Musical</h3>
        </div>

        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/Manufa.png') }}"  alt="vidio icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Manufacturing</h3>
        </div>

        <button id="next-expert-categories" class="absolute right-0 z-10 flex items-center justify-center w-10 h-10 -mr-6 -translate-y-1/2 bg-white border border-gray-300 rounded-full shadow-md top-1/2 hover:bg-gray-50 focus:outline-none">
            <img src="{{ asset('images/next.png')}}" alt="next btn">
        </button>
    </div>

    <div id="expert-categories-page-2" class="relative grid hidden grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/health.png') }}" alt="marketing icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Healthcare</h3>
        </div>

        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/finance.png') }}" alt="desing icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Finance & Banking</h3>
        </div>

        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/Estate.png') }}" alt="desing icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Real Estate</h3>
        </div>

        <div class="flex flex-col items-center justify-center p-6 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
            <img src="{{ asset('images/education.png') }}" alt="desing icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Education & Training</h3>
        </div>
        
        <div class="hidden lg:block"></div> 

        <button id="prev-expert-categories" class="absolute left-0 z-10 flex items-center justify-center w-10 h-10 -ml-6 -translate-y-1/2 bg-white border border-gray-300 rounded-full shadow-md top-1/2 hover:bg-gray-50 focus:outline-none">
            <img src="{{ asset('images/larrow.png') }}" alt="">
        </button>
    </div>

    <h2 class="mt-12 mb-6 text-2xl font-semibold text-gray-800">Help and resources</h2>

    <div class="flex items-center justify-between p-6 mb-6 bg-white border border-gray-200 rounded-lg shadow-sm">
        <div>
            <span class="block mb-2 text-sm font-medium text-gray-500">Get started</span>
            <h3 class="mb-4 text-xl font-bold text-gray-800">Get started and connect with talent to get work done</h3>
            <a href="#" class="inline-block px-4 py-2 font-semibold text-white transition-colors bg-blue-600 rounded-full hover:bg-blue-700">Learn more</a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
        <div class="flex items-start p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex-grow">
                <span class="block mb-2 text-sm font-medium text-gray-500">Payments</span>
                <h3 class="text-lg font-medium text-gray-800">Everything you need to know about payments</h3>
            </div>
            <img src="{{ asset('images/paymenyM.jpg') }}"  alt="Lock icon" class="w-20 h-20 ml-4"> </div>

        <div class="flex items-start p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex-grow">
                <span class="block mb-2 text-sm font-medium text-gray-500">Payments</span>
                <h3 class="text-lg font-medium text-gray-800">How to set up your preferred billing method</h3>
            </div>
            <img src="{{ asset('images/billing.jpg') }}"  alt="Card icon" class="w-20 h-20 ml-4"> </div>

        <div class="flex items-start p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex-grow">
                <span class="block mb-2 text-sm font-medium text-gray-500">Trust & safety</span>
                <h3 class="text-lg font-medium text-gray-800">Keep yourself and others safe on Upwork</h3>
            </div>
            <img src="{{ asset('images/safe.jpg') }}"  alt="Shield icon" class="w-20 h-20 ml-4"> </div>
    </div>
</div>

<script>
    const page1 = document.getElementById('expert-categories-page-1');
    const page2 = document.getElementById('expert-categories-page-2');
    const nextButton = document.getElementById('next-expert-categories');
    const prevButton = document.getElementById('prev-expert-categories');

    nextButton.addEventListener('click', () => {
        page1.classList.add('hidden');
        page2.classList.remove('hidden');
    });

    prevButton.addEventListener('click', () => {
        page2.classList.add('hidden');
        page1.classList.remove('hidden');
    });
</script>

@endsection()