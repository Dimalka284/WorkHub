@extends('layout.app')

@section('title', 'Edit Client Profile')

@section('content')
<!-- Page Container: Light background for contrast -->
<div class="min-h-screen py-10 bg-gray-50">
    <div class="max-w-4xl px-4 mx-auto sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Edit Client Profile</h1>
            <p class="text-gray-500">Update your personal information and company details.</p>
        </header>

        <!-- Main Content Card -->
        <div class="p-8 bg-white shadow-xl rounded-xl">

            <form action="{{ route('client.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Profile Picture Section -->
                <div class="pb-6 mb-8 border-b border-gray-200">
                    <h3 class="mb-4 text-xl font-semibold text-gray-800">Profile Picture</h3>
                    <div class="flex items-center space-x-6">
                        <!-- Current Profile Picture Placeholder (use $client->profilePic for actual image) -->
                        <div class="flex-shrink-0">
                            <img class="object-cover w-20 h-20 border-2 border-teal-500 rounded-full" 
                                src="{{ $client->profilePic ?? 'https://placehold.co/80x80/E0F2F1/14B8A6?text=P' }}" 
                                alt="Current Profile Picture">
                        </div>
                        
                        <!-- File Upload Input -->
                        <div class="flex-grow">
                            <label for="profilePic" class="block text-sm font-medium text-gray-700">Change Profile Photo</label>
                            <input type="file" name="profilePic" id="profilePic" class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-teal-50 file:text-teal-700 hover:file:bg-teal-100">
                            <p class="mt-1 text-xs text-gray-500">JPG or PNG allowed. Max size 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Personal Information Section -->
                <div class="pb-6 mb-8 border-b border-gray-200">
                    <h3 class="mb-4 text-xl font-semibold text-gray-800">Personal & Contact</h3>
                    
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        
                        {{-- First Name --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">First Name</span>
                            <input type="text" name="firstName" value="{{ $client->firstName }}" 
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5">
                        </label>

                        {{-- Last Name --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Last Name</span>
                            <input type="text" name="lastName" value="{{ $client->lastName }}" 
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5">
                        </label>

                        {{-- Email --}}
                        <label class="block sm:col-span-2">
                            <span class="text-sm font-medium text-gray-700">Email Address (Cannot be changed)</span>
                            <input type="email" name="email" value="{{ $client->email }}" disabled
                                class="w-full mt-1 bg-gray-100 border-gray-300 rounded-lg shadow-sm cursor-not-allowed p-2.5">
                        </label>
                    </div>
                </div>

                <!-- Company Details Section -->
                <div class="pb-6 mb-8">
                    <h3 class="mb-4 text-xl font-semibold text-gray-800">Company Details</h3>

                    <div class="grid grid-cols-1 gap-6">

                        {{-- Company Name --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Company Name</span>
                            <input type="text" name="companyName" value="{{ $client->companyName }}" 
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5">
                        </label>

                        {{-- Industry --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Industry</span>
                            <select name="industryId" 
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5">
                                @foreach ($industries as $industry)
                                    <option value="{{ $industry->industryId }}" 
                                        {{ $client->industryId == $industry->industryId ? 'selected' : '' }}>
                                        {{ $industry->industryName }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        {{-- Company Description --}}
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700">Company Description</span>
                            <textarea name="companyDescription" rows="4"
                                class="w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring-teal-500 p-2.5"
                                placeholder="A brief description of what your company does and what kind of talent you usually look for.">{{ $client->companyDescription }}</textarea>
                        </label>
                    </div>
                </div>

                <!-- Action Button -->
                <button type="submit"
                    class="w-full px-4 py-3 mt-4 text-base font-semibold text-white transition duration-150 ease-in-out bg-teal-600 rounded-lg shadow-md hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                    Save Changes
                </button>
            </form>

        </div>
    </div>
</div>
@endsection