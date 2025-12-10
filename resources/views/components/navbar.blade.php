
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-lg">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <!-- Logo and Primary Links (Desktop) -->
            <div class="flex items-center">
                <div class="flex items-center flex-shrink-0 mr-10">
                    <a href="/">
                        <span class="text-3xl font-extrabold tracking-tight text-teal-600">WorkHub</span>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8 lg:space-x-10">
                    <a href="/fdashboard" class="flex items-center px-1 pt-1 text-base font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">Hire Talent</a>
                    <a href="/dashboard" class="flex items-center px-1 pt-1 text-base font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">Manage Work</a>
                    
                    @if(session('clientID'))
                        <a href="{{ route('client.orders') }}" class="flex items-center px-1 pt-1 text-base font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">My Orders</a>
                    @endif

                    @if(session('freelancerID'))
                        <a href="{{ route('freelancer.orders') }}" class="flex items-center px-1 pt-1 text-base font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">My Gig Orders</a>
                        <a href="{{ route('applications.my') }}" class="flex items-center px-1 pt-1 text-base font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">My Applications</a>
                    @endif

                    <a href="#" class="flex items-center px-1 pt-1 text-base font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">Reports</a>
                </div>
            </div>

            <!-- Search, Auth/Profile, and Mobile Menu Toggle -->
            <div class="flex items-center space-x-4">
                
                <div class="relative hidden lg:block">
                    <input type="search" placeholder="Find Services or Talent"
                        class="block w-64 py-2 pl-4 pr-32 text-sm text-gray-900 transition duration-150 ease-in-out border border-gray-300 rounded-full focus:border-teal-500 focus:ring-1 focus:ring-teal-500"/>

                    <button class="absolute flex items-center h-[calc(100%-8px)] px-3 text-sm font-semibold text-white bg-teal-500 rounded-r-full inset-y-1 right-1 hover:bg-teal-600 transition duration-150">
                        Search
                    </button>
                </div>


               
                @if(session('clientID') || session('freelancerID'))
                    {{-- Notification Bell --}}
                    <div class="relative" id="notificationMenu">
                        <button id="notificationBtn" class="relative p-2 text-gray-700 transition duration-150 ease-in-out rounded-full hover:bg-gray-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            @php
                                $user = session('clientID') ? \App\Models\Client::find(session('clientID')) : \App\Models\Freelancer::find(session('freelancerID'));
                                $unreadCount = $user ? $user->unreadNotifications->count() : 0;
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">{{ $unreadCount }}</span>
                            @endif
                        </button>

                        {{-- Notification Dropdown --}}
                        <div id="notificationDropdown" class="absolute right-0 z-50 hidden w-80 mt-3 origin-top-right bg-white shadow-2xl rounded-xl ring-1 ring-black ring-opacity-5 max-h-96 overflow-hidden">
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                                    @if($unreadCount > 0)
                                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs text-teal-600 hover:text-teal-700">Mark all read</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="overflow-y-auto max-h-80">
                                @if($user && $user->notifications->count() > 0)
                                    @foreach($user->notifications->take(5) as $notification)
                                        <a href="{{ $notification->data['action_url'] ?? '#' }}" 
                                           onclick="event.preventDefault(); markAsRead('{{ $notification->id }}', '{{ $notification->data['action_url'] ?? '#' }}');"
                                           class="block px-4 py-3 transition duration-150 ease-in-out hover:bg-gray-50 {{ $notification->read_at ? 'bg-white' : 'bg-teal-50' }}">
                                            <div class="flex items-start">
                                                <div class="flex-1">
                                                    <p class="text-sm font-medium text-gray-900">{{ $notification->data['title'] ?? 'Notification' }}</p>
                                                    <p class="text-xs text-gray-600 mt-1">{{ $notification->data['message'] ?? '' }}</p>
                                                    <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <div class="w-2 h-2 mt-2 ml-2 bg-teal-500 rounded-full"></div>
                                                @endif
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('notifications.index') }}" class="block px-4 py-3 text-sm font-medium text-center text-teal-600 border-t border-gray-100 hover:bg-gray-50">
                                        View all notifications
                                    </a>
                                @else
                                    <div class="px-4 py-8 text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                        <p class="mt-2 text-sm">No notifications yet</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="relative" id="profileMenu">
                        <img src="{{ asset('images/profile.png') }}" 
                            alt="User Profile"
                            class="w-10 h-10 transition duration-150 ease-in-out border-2 border-transparent rounded-full cursor-pointer hover:border-teal-500" 
                            id="profileBtn">
                        
                        
                        <div id="dropdown"
                            class="absolute right-0 z-50 hidden w-64 mt-3 origin-top-right bg-white divide-y divide-gray-100 shadow-2xl rounded-xl ring-1 ring-black ring-opacity-5">
                            
                            <div class="p-4">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    Hello, {{ session('clientID') ? session('clientFirstName') : session('freelancerFirstName') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ session('clientID') ? 'Client Account' : 'Freelancer Account' }}
                                </p>
                            </div>

                            <div class="py-1">
                                @if(session('clientID'))
                                    <a href="{{ route('client.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="mr-2 fas fa-user-circle"></i> Your Profile
                                    </a>
                                @elseif(session('freelancerID'))
                                    <a href="{{ route('freelancer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="mr-2 fas fa-user-circle"></i> Your Profile
                                    </a>
                                @endif
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="mr-2 fas fa-cog"></i> Settings
                                </a>
                            </div>
                            
                            <div class="py-1">
                                <form action="{{route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-left text-red-600 hover:bg-gray-100">
                                        <i class="mr-2 fas fa-sign-out-alt"></i> Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="items-center hidden gap-2 sm:flex">
                        <a href="/login" 
                            class="px-4 py-2 text-base font-semibold text-teal-600 transition duration-150 ease-in-out border border-teal-600 rounded-full hover:bg-teal-50 hover:border-teal-700">
                            Log In
                        </a>
                        <a href="/account_type"
                            class="px-4 py-2 text-base font-semibold text-white transition duration-150 ease-in-out bg-teal-500 rounded-full hover:bg-teal-600">
                            Sign Up
                        </a>
                    </div>
                @endif

                <button type="button" id="mobileMenuBtn" class="sm:hidden inline-flex items-center justify-center p-2 text-gray-700 rounded-md sm:hiddenhover:bg-gray-100 aria-controls="mobile-menu" aria-expanded="false">
                    <img src="{{ asset('images/menubar.png') }}" alt="" class="w-10 h-10">
                    <i class="w-6 h-6 fa-solid fa-bars" id="menuIcon"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="hidden transition-all duration-300 ease-in-out sm:hidden" id="mobileMenu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            
            <a href="/fdashboard" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-600">Hire Talent</a>
            <a href="/dashboard" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-600">Manage Work</a>
            
            @if(session('clientID'))
                <a href="{{ route('client.orders') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-600">My Orders</a>
            @endif

            @if(session('freelancerID'))
                <a href="{{ route('freelancer.orders') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-600">My Gig Orders</a>
                <a href="{{ route('applications.my') }}" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-600">My Applications</a>
            @endif

            <a href="#" class="block px-3 py-2 text-base font-medium text-gray-700 rounded-md hover:bg-teal-50 hover:text-teal-600">Reports</a>
        </div>
        
        @if(!(session('clientID') || session('freelancerID')))
            <div class="px-2 pt-4 pb-2 space-y-2 border-t border-gray-100">
                <a href="/login" 
                    class="block w-full px-4 py-2 text-base font-semibold text-center text-teal-600 transition duration-150 ease-in-out border border-teal-600 rounded-lg hover:bg-teal-50">
                    Log In
                </a>
                <a href="/account_type"
                    class="block w-full px-4 py-2 text-base font-semibold text-center text-white transition duration-150 ease-in-out bg-teal-500 rounded-lg hover:bg-teal-600">
                    Sign Up
                </a>
            </div>
        @endif
    </div>
</nav>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const profileBtn = document.getElementById("profileBtn");
    const dropdown = document.getElementById("dropdown");
    const mobileMenuBtn = document.getElementById("mobileMenuBtn");
    const mobileMenu = document.getElementById("mobileMenu");
    const menuIcon = document.getElementById("menuIcon");
    const notificationBtn = document.getElementById("notificationBtn");
    const notificationDropdown = document.getElementById("notificationDropdown");

    
    if (profileBtn) {
        profileBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            dropdown.classList.toggle("hidden");
            if (notificationDropdown) notificationDropdown.classList.add("hidden");
        });
    }

    // Notification dropdown toggle
    if (notificationBtn) {
        notificationBtn.addEventListener("click", function (e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle("hidden");
            if (dropdown) dropdown.classList.add("hidden");
        });
    }

    document.addEventListener("click", function (event) {
        const profileMenu = document.getElementById("profileMenu");
        const notificationMenu = document.getElementById("notificationMenu");
        
        if (profileMenu && !profileMenu.contains(event.target)) {
            dropdown.classList.add("hidden");
        }
        
        if (notificationMenu && !notificationMenu.contains(event.target)) {
            notificationDropdown.classList.add("hidden");
        }
    });

    
    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");

            if (mobileMenu.classList.contains("hidden")) {
                menuIcon.classList.remove("fa-xmark");
                menuIcon.classList.add("fa-bars");
            } else {
                menuIcon.classList.remove("fa-bars");
                menuIcon.classList.add("fa-xmark");
            }
        });
    }
});

// Mark notification as read
function markAsRead(notificationId, actionUrl) {
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        window.location.href = actionUrl;
    });
}
</script>