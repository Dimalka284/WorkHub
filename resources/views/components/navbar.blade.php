<nav class="sticky top-0 z-40 bg-white border-b border-gray-100 shadow-lg">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            
            <div class="flex items-center space-x-8">
                <div class="flex items-center flex-shrink-0">
                    <span class="text-3xl font-extrabold tracking-tight text-teal-600">WorkHub</span>
                </div>

                <div class="hidden text-gray-700 sm:ml-6 sm:flex sm:space-x-8 lg:space-x-10">
                    <a href="/fdashboard" class="flex items-center px-1 pt-1 text-lg font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">Hire Talent</a>
                    <a href="/dashboard" class="flex items-center px-1 pt-1 text-lg font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">Manage Work</a>
                    <a href="#" class="flex items-center px-1 pt-1 text-lg font-medium text-gray-700 transition duration-150 ease-in-out border-b-2 border-transparent hover:border-teal-500 hover:text-teal-600">Reports</a>
                </div>
            </div>

            <!-- Search and Authentication/Profile -->
            <div class="flex items-center space-x-6">
                
                <!-- Search Bar (Integrated Style) -->
                <div class="relative hidden lg:block">
                    <input type="search" placeholder="Find Services or Talent"
                        class="block w-64 py-2 pl-4 pr-32 text-sm text-gray-900 transition duration-150 ease-in-out border border-gray-300 rounded-full focus:border-teal-500 focus:ring-1 focus:ring-teal-500"/>

                    <button class="absolute flex items-center h-[calc(100%-8px)] px-3 text-sm font-semibold text-white bg-teal-500 rounded-r-full inset-y-1 right-1 hover:bg-teal-600 transition duration-150">
                        Search
                    </button>
                </div>

                @if(session('clientID') || session('freelancerID'))
                    <div class="relative" id="profileMenu">
                        <img src="{{ asset('images/profile.png') }}" 
                            alt="User Profile"
                            class="w-10 h-10 transition duration-150 ease-in-out border-2 border-transparent rounded-full cursor-pointer hover:border-teal-500" 
                            id="profileBtn">
                        <div id="dropdown"
                            class="absolute right-0 hidden w-64 mt-3 origin-top-right bg-white divide-y divide-gray-100 shadow-2xl rounded-xl ring-1 ring-black ring-opacity-5">
                            
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
                    <div class="flex items-center gap-2">
                        <a href="/login" 
                            class="px-4 py-2 text-base font-semibold text-teal-600 transition duration-150 ease-in-out border border-teal-600 rounded-full hover:bg-teal-50 hover:border-teal-700">
                            Log In
                        </a>

                        <!-- Sign Up Button (Primary, Vibrant) -->
                        <a href="/account_type"
                            class="px-4 py-2 text-base font-semibold text-white transition duration-150 ease-in-out bg-teal-500 rounded-full hover:bg-teal-600">
                            Sign Up
                        </a>
                    </div>
                @endif

            </div>
        </div>
    </div>
</nav>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("profileBtn");
    const dropdown = document.getElementById("dropdown");

    if (btn) {
        btn.addEventListener("click", function () {
            dropdown.classList.toggle("hidden");
        });
    }

    // Close when clicking outside
    document.addEventListener("click", function (event) {
        const menu = document.getElementById("profileMenu");
        if (menu && !menu.contains(event.target)) {
            dropdown.classList.add("hidden");
        }
    });
});
</script>