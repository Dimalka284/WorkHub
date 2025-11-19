@extends('layout.app')

@section('title', 'Welcome')

@section('content')

<div class="px-4 py-10 mx-auto max-w-7xl">

    <div class="relative rounded-[30px] overflow-hidden shadow-xl">

        <img 
            src="{{ asset('images/mainimg.jpg') }}" 
            class="w-full h-[450px] md:h-[600px] object-cover"
        >

        <div class="absolute inset-0 bg-black/40"></div>
        <div class="absolute inset-0 flex flex-col justify-center px-6 md:px-16">

            <h1 class="text-white font-extrabold text-4xl md:text-6xl leading-tight w-full md:w-[60%]">
                Connecting clients <br>
                in need to freelancers <br>
                who deliver
            </h1>

            <div class="max-w-lg p-6 mt-8 border rounded-2xl bg-white/10 backdrop-blur-md border-white/20">

                <div class="flex p-1 space-x-2 rounded-full bg-black/20">

                    <button id="findTalentBtn"
                        class="flex-1 py-2 font-medium text-white transition rounded-full bg-white/20 hover:bg-white/30">
                        Find talent
                    </button>

                    <button id="browseJobsBtn"
                        class="flex-1 py-2 font-medium text-white transition border rounded-full border-white/30 hover:bg-white/20">
                        Browse jobs
                    </button>

                </div>
                <div id="talentContent" class="mt-4 text-sm text-white">
                    Build your freelancing career on WorkHub, with 
                    thousands of jobs posted every week.

                    <button class="px-6 py-2 mt-4 font-semibold text-white bg-green-600 rounded-full shadow hover:bg-green-700">
                        Explore recently posted jobs
                    </button>
                </div>
                <div id="jobsContent" class="hidden mt-4 text-sm text-white">
                    100,000+ talented freelancers ready to work with you.

                    <div class="relative mt-4">
                        <input 
                            type="text" 
                            placeholder="Search talent…" 
                            class="w-full px-4 py-2 text-black rounded-full outline-none"
                        >
                        <button 
                            class="absolute px-4 py-1 text-sm text-white bg-blue-600 rounded-full right-1 top-1 hover:bg-blue-700">
                            Search
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
<div class="container px-4 py-8 mx-auto">
    <h2 class="mb-8 text-4xl font-semibold text-gray-800">Explore millions of pros</h2>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Development & IT</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h14a2 2 0 012 2v12a4 4 0 01-4 4h-4a2 2 0 01-2-2v-2a2 2 0 00-2-2H9a2 2 0 00-2 2v2a2 2 0 01-2 2zm0-12h9"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Design & Creative</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">AI Services</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.636 18.364a9 9 0 010-12.728m2.828 9.9a5 5 0 010-7.072M12 12h.01"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Sales & Marketing</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.9l4.243 4.243m-4.243-4.243a1.5 1.5 0 012.121 0L19.5 7.757m-9.9 10.5h2.828a1 1 0 00.707-.293l5.071-5.071a1 1 0 00-.707-1.707l-2.828-2.828m-6.364-1.414a1 1 0 010 1.414l-4.243 4.243"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Writing & Translation</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Admin & Support</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Finance & Accounting</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.276a1.125 1.125 0 011.087 1.087l-1.087 1.087a1.125 1.125 0 01-1.087-1.087l1.087-1.087zM5.618 18.276a1.125 1.125 0 01-1.087-1.087l1.087-1.087a1.125 1.125 0 011.087 1.087l-1.087 1.087zM12 2a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V4a2 2 0 00-2-2h-2zm-6 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V4a2 2 0 00-2-2H6zm12 0a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V4a2 2 0 00-2-2h-2z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Legal</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h-5m-7 0h5m-5 0a2 2 0 110-4h4a2 2 0 110 4m-5 0h5M13 18H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v7a2 2 0 01-2 2h-4m-7-2v5a2 2 0 002 2h2a2 2 0 002-2v-5"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">HR & Training</h3>
        </div>

        <div class="flex flex-col items-start p-6 transition-shadow duration-200 bg-white border border-gray-200 rounded-lg shadow-sm cursor-pointer hover:shadow-md">
            <svg class="w-10 h-10 mb-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4h-.01M4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2zM10 12H7a1 1 0 00-1 1v4a1 1 0 001 1h3a1 1 0 001-1v-4a1 1 0 00-1-1zm4-6h3a1 1 0 001 1v4a1 1 0 00-1 1h-3a1 1 0 00-1-1V7a1 1 0 001-1z"></path>
            </svg>
            <h3 class="text-lg font-medium text-gray-800">Engineering & Architecture</h3>
        </div>

    </div>
</div>

<script>
    const findBtn = document.getElementById('findTalentBtn');
    const jobsBtn = document.getElementById('browseJobsBtn');
    const talent = document.getElementById('talentContent');
    const jobs = document.getElementById('jobsContent');

    findBtn.onclick = () => {
        findBtn.classList.add('bg-white/20');
        findBtn.classList.remove('border');
        jobsBtn.classList.remove('bg-white/20');
        jobsBtn.classList.add('border');

        talent.classList.remove('hidden');
        jobs.classList.add('hidden');
    };

    jobsBtn.onclick = () => {
        jobsBtn.classList.add('bg-white/20');
        jobsBtn.classList.remove('border');
        findBtn.classList.remove('bg-white/20');
        findBtn.classList.add('border');

        jobs.classList.remove('hidden');
        talent.classList.add('hidden');
    };
</script>

@endsection
