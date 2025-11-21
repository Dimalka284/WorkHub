<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up to hire talent </title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white">

    <header class="flex items-center justify-between p-6 border-b border-gray-100">
        <div class="text-2xl font-bold tracking-tighter text-black">
            <span class="text-blue-600">Work</span>Hub
        </div>
        <div class="flex items-center space-x-4 text-sm">
            <p class="text-gray-500 hover:text-gray-900">Looking for work?</p>
            <a href="/freelancer_ac" class="font-medium text-blue-600 hover:text-blue-900">Apply as talent</a>
        </div>
    </header>

    <main class="flex flex-col items-center px-4 py-10 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg">
            
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-normal text-gray-800">
                    Sign up to hire talent
                </h2>
            </div>
            
            <div class="mb-6 space-y-3">
                <a href="/auth/google/client">
                <div class="flex space-x-4">
                    <button
                    type="button"
                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                    <span class="px-2 text-gray-500 bg-white">
                        or
                    </span>
                </div>
            </div>
            
            <form class="space-y-6" action="{{route('client.signup')}}" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">First name</label>
                        <input name="firstname" type="text" required class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last name</label>
                        <input name="lastname" type="text" autocomplete="family-name" required class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Work email address</label>
                    <input name="email" type="email" required class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @if (session('error'))
                        <p class="mb-2 text-sm text-red-500">{{ session('error') }}</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <input name="password" type="password" required placeholder="Password (8 or more characters)" class="block w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 cursor-pointer">
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Company name</label>
                        <input name="companyname" type="text"  class="block w-full px-3 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div>
                    <label class="block text-sm font-medium text-gray-700">Industry</label>
                    <select id="industry" name="industry"  class="block w-full py-2 pl-3 pr-10 mt-1 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @foreach ($industries as $industry) 
                        <option value="{{ $industry->industryId }}">{{ $industry->industryName }}</option>
                        @endforeach
                    </select>
                </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="terms" name="terms" type="checkbox" required class="w-4 h-4 text-green-600 border-gray-300 rounded focus:ring-green-500">
                        </div>
                        <div class="ml-3 text-sm text-gray-500">
                            <p>Yes, I understand and agree to the Upwork Terms of Service, including the User Agreement and Privacy Policy.</p>
                        </div>
                    </div>
                </div>

                <div class="pt-2 pb-4 text-center">
                    <button
                        type="submit"
                        class="inline-flex justify-center px-12 py-2 text-base font-medium text-black transition duration-150 ease-in-out bg-blue-200 border border-transparent rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700">
                        Create my account
                    </button>
                </div>
            </form>

            <div class="pt-4 text-center">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="/login" class="font-medium text-blue-600 hover:text-blue-900">
                        Log In
                    </a>
                </p>
            </div>

        </div>
    </main>

</body>
</html>