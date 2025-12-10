@extends('layout.app')

@section('title', 'My Gig Orders')

@section('content')
<div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    
    <div class="flex flex-col items-start justify-between pb-4 mb-10 border-b sm:flex-row sm:items-center">
        <div>
            <h1 class="mb-2 text-3xl font-extrabold tracking-tight text-gray-800 sm:text-4xl">
                My Gig Orders
            </h1>
            <p class="text-gray-600">Manage orders for your gigs</p>
        </div>
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
                                            Client: {{ $order->client->firstName }} {{ $order->client->lastName }}
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
                                    <p class="text-sm text-gray-600 whitespace-pre-line">{{ $order->requirements }}</p>
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

                                @if($order->latestDelivery)
                                    <div class="p-3 mt-3 border border-purple-200 rounded-lg bg-purple-50">
                                        <p class="mb-1 text-sm font-semibold text-purple-900">Latest Delivery (Revision #{{ $order->latestDelivery->revision_number }})</p>
                                        <p class="text-xs text-purple-700">{{ $order->latestDelivery->delivery_message }}</p>
                                    </div>
                                @endif
                            </div>

                            {{-- Right: Actions --}}
                            <div class="flex flex-col gap-2 md:w-48">
                                @if($order->status === 'pending')
                                    <form action="{{ route('order.accept', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full px-4 py-2 text-sm font-medium text-white transition bg-green-600 rounded-lg hover:bg-green-700">
                                            Accept Order
                                        </button>
                                    </form>

                                    <form action="{{ route('order.reject', $order->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to reject this order?')"
                                                class="w-full px-4 py-2 text-sm font-medium text-white transition bg-red-600 rounded-lg hover:bg-red-700">
                                            Reject Order
                                        </button>
                                    </form>
                                @elseif($order->status === 'in_progress' || $order->status === 'revision_requested')
                                    <button onclick="openDeliveryModal({{ $order->id }})" 
                                            class="w-full px-4 py-2 text-sm font-medium text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                                        @if($order->status === 'revision_requested')
                                            Re-Submit Delivery
                                        @else
                                            Submit Delivery
                                        @endif
                                    </button>
                                @elseif($order->status === 'delivered')
                                    <div class="p-3 text-center text-purple-700 bg-purple-100 rounded-lg">
                                        <p class="text-sm font-semibold">Awaiting Client Review</p>
                                    </div>
                                @elseif($order->status === 'completed')
                                    <div class="p-3 text-center text-green-700 bg-green-100 rounded-lg">
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p class="text-sm font-semibold">Completed</p>
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
            <p class="mb-4 text-xl text-gray-500">No orders yet.</p>
            <p class="text-gray-400">Orders for your gigs will appear here!</p>
        </div>
    @endif
</div>

{{-- Delivery Submission Modal --}}
<div id="deliveryModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true" onclick="closeDeliveryModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <form id="deliveryForm" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Submit Delivery
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label for="delivery_message" class="block text-sm font-medium text-gray-700">Delivery Message *</label>
                                    <textarea id="delivery_message" name="delivery_message" rows="3" required
                                              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                              placeholder="Describe what you've delivered..."></textarea>
                                </div>

                                <div>
                                    <label for="delivery_url" class="block text-sm font-medium text-gray-700">Delivery URL (Optional)</label>
                                    <input type="url" id="delivery_url" name="delivery_url"
                                           class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                           placeholder="https://example.com/your-work">
                                </div>

                                <div>
                                    <label for="delivery_files" class="block text-sm font-medium text-gray-700">Upload Files (Optional)</label>
                                    <input type="file" id="delivery_files" name="delivery_files[]" multiple
                                           class="block w-full mt-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="mt-1 text-xs text-gray-500">Max 10MB per file</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Submit Delivery
                    </button>
                    <button type="button" onclick="closeDeliveryModal()" class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openDeliveryModal(orderId) {
        const form = document.getElementById('deliveryForm');
        form.action = `/orders/${orderId}/deliver`;
        document.getElementById('deliveryModal').classList.remove('hidden');
    }

    function closeDeliveryModal() {
        document.getElementById('deliveryModal').classList.add('hidden');
        document.getElementById('deliveryForm').reset();
    }
</script>
@endsection
