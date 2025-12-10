@extends('layout.app')

@section('title', 'My Orders')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <div class="flex flex-col items-start justify-between pb-4 mb-10 border-b sm:flex-row sm:items-center">
        <div>
            <h1 class="mb-2 text-3xl font-extrabold tracking-tight text-gray-800 sm:text-4xl">
                My Orders
            </h1>
            <p class="text-gray-600">Track and manage your gig orders</p>
        </div>
        <a href="{{ route('gigs.browse') }}" class="px-6 py-3 mt-4 text-white transition bg-blue-600 rounded-lg shadow hover:bg-blue-700 sm:mt-0">
            Browse More Gigs
        </a>
    </div>

    @if(session('success'))
        <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-400 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="overflow-hidden transition-shadow bg-white border border-gray-200 shadow-md rounded-xl hover:shadow-lg">
                    <div class="p-6">
                        <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                            {{-- Left: Order Info --}}
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900">{{ $order->gig->display_name }}</h3>
                                        <p class="text-sm text-gray-500">
                                            Freelancer: {{ $order->freelancer->firstName }} {{ $order->freelancer->lastName }}
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'accepted' || $order->status === 'in_progress') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'delivered') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-green-100 text-green-800
                                        @elseif($order->status === 'rejected') bg-red-100 text-red-800
                                        @elseif($order->status === 'revision_requested') bg-orange-100 text-orange-800
                                        @endif">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <p class="text-sm font-medium text-gray-700">Requirements:</p>
                                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ Str::limit($order->requirements, 200) }}</p>
                                </div>

                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    @if($order->budget)
                                        <span><strong>Budget:</strong> ${{ number_format($order->budget, 2) }}</span>
                                    @endif
                                    @if($order->deadline)
                                        <span><strong>Deadline:</strong> {{ $order->deadline->format('M d, Y') }}</span>
                                    @endif
                                    <span><strong>Ordered:</strong> {{ $order->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            {{-- Right: Actions --}}
                            <div class="flex flex-col gap-2 md:w-48">
                                @if($order->status === 'delivered' && $order->latestDelivery)
                                    {{-- Show Delivery Details --}}
                                    <div class="p-4 mb-3 border border-purple-200 rounded-lg bg-purple-50">
                                        <p class="mb-2 text-sm font-semibold text-purple-900">Delivery Received</p>
                                        <p class="mb-2 text-xs text-purple-700">{{ $order->latestDelivery->delivery_message }}</p>
                                        
                                        @if($order->latestDelivery->delivery_url)
                                            <a href="{{ $order->latestDelivery->delivery_url }}" target="_blank" 
                                               class="block mb-2 text-xs text-blue-600 hover:underline">
                                                View Delivery Link
                                            </a>
                                        @endif

                                        @if($order->latestDelivery->delivery_files)
                                            <p class="mb-2 text-xs font-medium text-purple-700">Files:</p>
                                            @foreach($order->latestDelivery->delivery_files as $file)
                                                <a href="{{ asset('storage/' . $file) }}" target="_blank" 
                                                   class="block mb-1 text-xs text-blue-600 hover:underline">
                                                    📎 {{ basename($file) }}
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>

                                    <form action="{{ route('order.accept.delivery', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 text-sm font-medium text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                                            Accept Delivery
                                        </button>
                                    </form>

                                    <button onclick="openRevisionModal({{ $order->id }})" 
                                            class="w-full px-4 py-2 text-sm font-medium text-white transition bg-orange-600 rounded-lg hover:bg-orange-700">
                                        Request Revision
                                    </button>
                                @elseif($order->status === 'completed')
                                    <div class="p-3 text-center text-green-700 bg-green-100 rounded-lg">
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm font-semibold">Order Completed</p>
                                    </div>
                                @elseif($order->status === 'rejected')
                                    <div class="p-3 text-center text-red-700 bg-red-100 rounded-lg">
                                        <p class="text-sm font-semibold">Order Rejected</p>
                                    </div>
                                @else
                                    <div class="p-3 text-center text-gray-600 bg-gray-100 rounded-lg">
                                        <p class="text-xs">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="py-16 text-center bg-white shadow-lg rounded-xl">
            <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="mb-4 text-xl text-gray-500">You haven't placed any orders yet.</p>
            <a href="{{ route('gigs.browse') }}" class="font-semibold text-indigo-600 hover:text-indigo-700">
                Browse gigs to get started!
            </a>
        </div>
    @endif
</div>

{{-- Revision Request Modal --}}
<div id="revisionModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeRevisionModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="revisionForm" method="POST">
                @csrf
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-orange-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Request Revision
                            </h3>
                            <div class="mt-4">
                                <label for="revision_notes" class="block text-sm font-medium text-gray-700">What needs to be changed? *</label>
                                <textarea id="revision_notes" name="revision_notes" rows="4" required
                                          class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500 sm:text-sm"
                                          placeholder="Describe the changes you need..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-orange-600 border border-transparent rounded-md shadow-sm hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Submit Revision Request
                    </button>
                    <button type="button" onclick="closeRevisionModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openRevisionModal(orderId) {
        const form = document.getElementById('revisionForm');
        form.action = `/orders/${orderId}/request-revision`;
        document.getElementById('revisionModal').classList.remove('hidden');
    }

    function closeRevisionModal() {
        document.getElementById('revisionModal').classList.add('hidden');
        document.getElementById('revision_notes').value = '';
    }
</script>
@endsection
