@extends('layout.app')

@section('title', 'Edit Freelancer Profile')

@section('content')
<!-- Page Container: Light background for contrast -->
<div class="min-h-screen py-10 bg-gray-50">
    <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Freelancer Profile</h1>
            <p class="text-gray-500">Showcase your skills and experience to attract clients.</p>
        </header>

        <!-- Main Content Card -->
        <div class="p-8 bg-white shadow-xl rounded-xl">

            <form action="{{ route('freelancer.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- 1. Personal Information Section -->
                <div class="pb-6 mb-8 border-b border-gray-200">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800">Personal & Contact</h3>
                    
                    <!-- Profile Picture Upload -->
                    <div class="flex items-center mb-8 space-x-6">
                        <div class="flex-shrink-0">
                            <!-- Current Profile Picture Placeholder -->
                            <img class="object-cover w-20 h-20 border-2 border-teal-500 rounded-full" 
                                src="{{ $freelancer->profilePic ?? 'https://placehold.co/80x80/E0F2F1/14B8A6?text=FP' }}" 
                                alt="Current Profile Picture">
                        </div>
                        
                        <!-- File Upload Input -->
                        <div class="flex-grow">
                            <label for="profilePic" class="block text-sm font-medium text-gray-700">Change Profile Photo</label>
                            <input type="file" name="profilePic" id="profilePic" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                            <p class="mt-1 text-xs text-gray-500">A clear photo helps build trust with clients. JPG or PNG allowed.</p>
                        </div>
                    </div>

                    <!-- Name and Email Inputs -->
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        
                        {{-- First Name --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">First Name</span>
                            <input type="text" name="firstName" value="{{ $freelancer->firstName }}" 
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5">
                        </label>

                        {{-- Last Name --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Last Name</span>
                            <input type="text" name="lastName" value="{{ $freelancer->lastName }}" 
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5">
                        </label>

                        {{-- Email (Disabled) --}}
                        <label class="block sm:col-span-2">
                            <span class="text-sm font-medium text-gray-700">Email Address (Primary Contact)</span>
                            <input type="email" name="email" value="{{ $freelancer->email }}" disabled
                                class="w-full mt-1 bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed p-2.5">
                        </label>
                    </div>
                </div>

                <!-- 2. Professional Summary Section -->
                <div class="pb-6 mb-8">
                    <h3 class="mb-6 text-xl font-semibold text-gray-800">Professional Summary</h3>

                    <div class="grid grid-cols-1 gap-6">

                        {{-- Bio / Description --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Professional Bio (Overview)</span>
                            <textarea name="bio" rows="6"
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5"
                                placeholder="Write a compelling summary of your skills, expertise, and what you offer to clients. (Min 100 characters)">{{ $freelancer->bio }}</textarea>
                        </label>

                        {{-- LinkedIn Profile --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">LinkedIn Profile URL</span>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <!-- Simple Link Icon -->
                                    <i class="text-gray-400 fas fa-link"></i>
                                </div>
                                <input type="text" name="linkedInProfile" value="{{ $freelancer->linkedInProfile }}" 
                                    class="w-full pl-10 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5"
                                    placeholder="e.g., https://linkedin.com/in/yourname">
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit"
                    class="w-full px-4 py-3 mt-4 text-base font-semibold text-white transition duration-150 ease-in-out bg-teal-600 rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Save Profile
                </button>
            </form>

        </div>
    </div>
</div>
@endsection