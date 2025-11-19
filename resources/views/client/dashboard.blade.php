@extends('layout.app')

@section('title','dashboard')
@section('content')
<div class="flex justify-end">  
    <a href="/post"><button 
    class="px-6 py-2 text-lg font-semibold bg-blue-600 text-white rounded-xl shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 active:bg-blue-800 transition duration-150 ease-in-out">
    Post a Job
</button></a>
</div>
<div class="container mx-auto px-4 py-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Find experts by category and book consultations</h2>
        <a href="#" class="flex items-center text-blue-600 hover:text-blue-700 font-medium">
            Browse consultations
            <img src="{{ asset('images/arrow.png') }}" alt="arrow" class="w-8 h-8 mx-2">
        </a>
    </div>

    <div id="expert-categories-page-1" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/webD.png') }}" alt="Website Development icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Website Developement</h3>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/LogoD.png') }}"  alt="logo icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Logo Desing</h3>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/creativewritingD.png') }}" alt="writing" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Creative Writing</h3>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/vidioD.png') }}"  alt="vidio icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Video & Animation</h3>
        </div>

        <button id="next-expert-categories" class="absolute right-0 top-1/2 -translate-y-1/2 -mr-6 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center border border-gray-300 hover:bg-gray-50 focus:outline-none z-10">
            <img src="{{ asset('images/next.png')}}" alt="next btn">
        </button>
    </div>

    <div id="expert-categories-page-2" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative hidden">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/marketingD.png') }}" alt="marketing icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Digital Marketing</h3>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex flex-col items-center justify-center text-center">
            <img src="{{ asset('images/desingD.png') }}" alt="desing icon" class="w-16 h-16 mb-4"> <h3 class="text-lg font-medium text-gray-800">Graphics & Design</h3>
        </div>

        <div class="hidden lg:block"></div> 

        <button id="prev-expert-categories" class="absolute left-0 top-1/2 -translate-y-1/2 -ml-6 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center border border-gray-300 hover:bg-gray-50 focus:outline-none z-10">
            <img src="{{ asset('images/larrow.png') }}" alt="">
        </button>
        <button class="absolute right-0 top-1/2 -translate-y-1/2 -mr-6 w-10 h-10 rounded-full bg-white shadow-md flex items-center justify-center border border-gray-300 hover:bg-gray-50 focus:outline-none z-10">
            <img src="{{ asset('images/next.png') }}" alt="next btn">
        </button>
    </div>

    <h2 class="text-2xl font-semibold text-gray-800 mt-12 mb-6">Help and resources</h2>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex justify-between items-center mb-6">
        <div>
            <span class="text-sm text-gray-500 font-medium block mb-2">Get started</span>
            <h3 class="text-xl font-bold text-gray-800 mb-4">Get started and connect with talent to get work done</h3>
            <a href="#" class="inline-block bg-blue-600 text-white font-semibold py-2 px-4 rounded-full hover:bg-blue-700 transition-colors">Learn more</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-start">
            <div class="flex-grow">
                <span class="text-sm text-gray-500 font-medium block mb-2">Payments</span>
                <h3 class="text-lg font-medium text-gray-800">Everything you need to know about payments</h3>
            </div>
            <img src="{{ asset('images/paymenyM.jpg') }}"  alt="Lock icon" class="w-20 h-20 ml-4"> </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-start">
            <div class="flex-grow">
                <span class="text-sm text-gray-500 font-medium block mb-2">Payments</span>
                <h3 class="text-lg font-medium text-gray-800">How to set up your preferred billing method</h3>
            </div>
            <img src="{{ asset('images/billing.jpg') }}"  alt="Card icon" class="w-20 h-20 ml-4"> </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 flex items-start">
            <div class="flex-grow">
                <span class="text-sm text-gray-500 font-medium block mb-2">Trust & safety</span>
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