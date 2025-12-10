<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Notifications - WorkHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <x-navbar/>

    <div class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="mt-2 text-sm text-gray-600">Stay updated with your order activities</p>
        </div>

        @if(session('success'))
            <div class="p-4 mb-6 text-green-700 bg-green-100 border border-green-200 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden bg-white shadow-sm rounded-lg">
            @if($notifications->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($notifications as $notification)
                        <div class="p-6 transition duration-150 ease-in-out hover:bg-gray-50 {{ $notification->read_at ? '' : 'bg-teal-50' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </h3>
                                        @if(!$notification->read_at)
                                            <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-teal-100 text-teal-800">
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">{{ $notification->data['message'] ?? '' }}</p>
                                    <div class="flex items-center mt-3 space-x-4 text-xs text-gray-500">
                                        <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        @if(isset($notification->data['order_id']))
                                            <span>•</span>
                                            <span>Order #{{ $notification->data['order_id'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center ml-4 space-x-2">
                                    @if(isset($notification->data['action_url']))
                                        <a href="{{ $notification->data['action_url'] }}" 
                                           class="px-4 py-2 text-sm font-medium text-white transition duration-150 ease-in-out bg-teal-600 rounded-lg hover:bg-teal-700">
                                            View
                                        </a>
                                    @endif
                                    @if(!$notification->read_at)
                                        <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" 
                                                    class="px-4 py-2 text-sm font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                                                Mark as read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No notifications</h3>
                    <p class="mt-2 text-sm text-gray-500">You're all caught up! Check back later for updates.</p>
                </div>
            @endif
        </div>
    </div>

    <x-footer />
</body>
</html>
