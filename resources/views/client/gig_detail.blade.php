@extends('layout.app')

@section('title', $gig->display_name)

@section('content')
<div class="max-w-6xl px-4 py-12 mx-auto">
    <a href="{{ route('gigs.browse') }}" class="inline-flex items-center mb-6 text-blue-600 transition hover:text-blue-700">
        <img src="{{ asset('images/larrow.png') }}" alt="Back" class="w-8 h-8 mr-2">
        <span class="text-lg font-medium">Back to Gigs</span>
    </a>

    <div class="overflow-hidden bg-white shadow-xl rounded-2xl md:flex">
        {{-- Left: Image --}}
        @if($gig->profileimg)
            <div class="overflow-hidden md:w-1/3 h-80 md:h-auto">
                <img src="{{ asset('storage/' . $gig->profileimg) }}" 
                     alt="{{ $gig->display_name }}" 
                     class="object-cover w-full h-full">
            </div>
        @else
            <div class="flex items-center justify-center overflow-hidden bg-gradient-to-br from-indigo-100 to-purple-100 md:w-1/3 h-80 md:h-auto">
                <svg class="w-24 h-24 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        @endif

        {{-- Right: Details --}}
        <div class="flex flex-col justify-between gap-6 p-8 md:w-2/3">

            {{-- Gig Title & Description --}}
            <div>
                <h1 class="mb-3 text-3xl font-bold text-gray-800">{{ $gig->display_name }}</h1>
                <p class="mb-6 text-lg leading-relaxed text-gray-600">{{ $gig->description }}</p>
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
                        @if($gig->freelancer->linkedInProfile)
                            <li><strong>LinkedIn:</strong> 
                                <a href="{{ $gig->freelancer->linkedInProfile }}" target="_blank" class="text-blue-600 hover:underline">
                                    View Profile
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
                        <span class="px-4 py-2 text-sm font-medium text-white transition transform rounded-full shadow bg-gradient-to-r from-sky-500 to-blue-700 hover:scale-105">
                            {{ $skill->name }} ({{ $skill->pivot->experienceLevel }})
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Order Button --}}
            @if(session('clientID'))
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <button onclick="openOrderModal()" 
                            class="flex items-center justify-center w-full px-8 py-4 text-lg font-semibold text-white transition duration-200 ease-in-out bg-green-600 shadow-lg rounded-xl shadow-green-200 hover:bg-green-700 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-50">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Place Order
                    </button>
                </div>
            @else
                <div class="pt-6 mt-6 border-t border-gray-200">
                    <p class="mb-4 text-center text-gray-600">Please log in as a client to place an order</p>
                    <a href="/login" class="flex items-center justify-center w-full px-8 py-4 text-lg font-semibold text-white transition duration-200 ease-in-out bg-blue-600 shadow-lg rounded-xl hover:bg-blue-700">
                        Login
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Order Modal --}}
<div id="orderModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeOrderModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form action="{{ route('order.place', $gig->id) }}" method="POST">
                @csrf
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-green-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Place Order for {{ $gig->display_name }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements *</label>
                                    <textarea id="requirements" name="requirements" rows="4" required
                                              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                              placeholder="Describe what you need..."></textarea>
                                </div>

                                <div>
                                    <label for="budget" class="block text-sm font-medium text-gray-700">Budget (Optional)</label>
                                    <input type="number" id="budget" name="budget" step="0.01" min="0"
                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                           placeholder="Enter your budget">
                                </div>

                                <div>
                                    <label for="deadline" class="block text-sm font-medium text-gray-700">Deadline (Optional)</label>
                                    <input type="date" id="deadline" name="deadline"
                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-green-600 border border-transparent rounded-md shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Submit Order
                    </button>
                    <button type="button" onclick="closeOrderModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openOrderModal() {
        document.getElementById('orderModal').classList.remove('hidden');
    }

    function closeOrderModal() {
        document.getElementById('orderModal').classList.add('hidden');
    }

    // Set minimum date to tomorrow
    const deadlineInput = document.getElementById('deadline');
    if (deadlineInput) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        deadlineInput.min = tomorrow.toISOString().split('T')[0];
    }
</script>
@endsection
