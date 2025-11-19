<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-6">
                <div class="flex items-center flex-shrink-0">
                    <span class="text-3xl font-extrabold text-blue-700">Work</span>
                    <span class="text-3xl font-extrabold text-gray-800">Hub</span>
                </div>

                <div class="hidden text-gray-700 sm:ml-6 sm:flex sm:space-x-6">
                    <a href="/fdashboard" class="font-medium text-m hover:text-blue-600">Hire talent</a>
                    <a href="/dashboard" class="font-medium text-m hover:text-blue-600">Manage work</a>
                    <a href="#" class="font-medium text-m hover:text-blue-600">Reports</a>
                </div>
            </div>
            <div class="flex items-center space-x-8">
                <div class="relative hidden lg:block">
                    <input 
                        type="search" 
                        placeholder="Search" 
                        class="block py-2 pl-10 text-base text-gray-900 transition duration-200 border border-gray-300 rounded-full w-80 pr-28 focus:border-blue-600 focus:ring-1 focus:ring-blue-600"
                    />
                    
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <img src="{{ asset('images/search.png') }}" alt="Search" class="w-5 h-5">  
                    </div>
                    
                    <button 
                        class="absolute flex items-center h-auto px-3 py-1 text-sm font-medium text-gray-700 border-l border-gray-300 rounded-full inset-y-1 right-1 bg-gray-50 hover:bg-gray-100"
                    >
                        Talent
                    </button>
                </div>
                <div class="flex items-center">
                    <a href="/profile">
                        <img src="{{ asset('images/profile.png') }}" alt="Profile" class="w-10 h-10">  
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/login"
                       class="px-5 py-2 text-sm font-medium text-blue-600 transition border border-blue-600 rounded-full hover:bg-blue-600 hover:text-white">
                        Login
                    </a>

                    <a href="/account_type"
                       class="px-5 py-2 text-sm font-medium text-white transition bg-blue-600 rounded-full shadow hover:bg-blue-700">
                        Sign Up
                    </a>
                </div>
            </div>

        </div>
    </div>
</nav>
