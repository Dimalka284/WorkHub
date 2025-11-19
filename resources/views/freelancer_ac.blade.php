<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up to find work </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen">

    <header class="flex justify-between items-center p-6 border-b border-gray-100">
        <div class="text-2xl font-bold text-black tracking-tighter">
            <span class="text-blue-600">Work</span>Hub
        </div>
        <div class="flex items-center space-x-4 text-sm">
            <p class="text-gray-500 hover:text-gray-900">Looking for work?</p>
            <a href="/client_ac" class="text-blue-600 font-medium hover:text-blue-900">Join as a Client</a>
        </div>
    </header>

    <main class="flex flex-col items-center py-10 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-normal text-gray-800">
                    Sign up to find work you love
                </h2>
            </div>
            
            <div class="space-y-3 mb-6">
                <a href="/auth/google/freelancer">
                <div class="flex space-x-4">
                    <button
                    type="button"
                    class="w-full flex justify-center items-center py-2 px-4 border border-gray-300 rounded-full shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                <img src="{{ asset('images/google.png') }}" alt="People" class="w-5 h-5 mx-2">
                    Continue with Google
                </button>
                </div></a>
            </div>
            
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        or
                    </span>
                </div>
            </div>
            
            <form class="space-y-6" action= {{route('freelancer.signup')}} method = "POST">
                 @csrf 
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First name</label>
                        <input name="firstname" type="text" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last name</label>
                        <input name="lastname" type="text" autocomplete="family-name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Work email address</label>
                    <input name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input name="password" type="password" required placeholder="Password (8 or more characters)" class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm pr-10">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 cursor-pointer">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">

                <div class="space-y-1">
                    <div class="flex justify-between items-end">
                        <label for="bio" class="block text-sm font-medium text-gray-700">
                            Professional Bio / Summary
                        </label>
                        <span class="text-xs text-gray-400">
                            250 characters minimum
                        </span>
                    </div>

                    <textarea
                        id="bio"
                        name="bio"
                        rows="5"
                        placeholder="Tell us about yourself, your skills, and what you specialize in. This helps clients find you faster."
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm resize-y"
                        maxlength="2000"
                        required
                    ></textarea>
                    
                    <p class="text-xs text-gray-500 mt-1">
                        Clients often look at your bio first. Make it count!
                    </p>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required class="focus:ring-green-500 h-4 w-4 text-green-600 border-gray-300 rounded">
                        </div>
                        <div class="ml-3 text-sm text-gray-500">
                            <p>Yes, I understand and agree to the Upwork Terms of Service, including the User Agreement and Privacy Policy.</p>
                        </div>
                    </div>
                </div>

            </form>

            <div class="text-center pt-4">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="/login" class="text-blue-600 font-medium hover:text-blue-900">
                        Log In
                    </a>
                </p>
            </div>

        </div>
    </main>

</body>
</html>