<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WorkHub Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-50">

    <header class="p-6">
        <div class="text-2xl font-bold tracking-tighter text-black">
            <span class="text-blue-600">Work</span>Hub
        </div>
    </header>

    <main class="flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
        <div class="w-full max-w-md p-8 bg-white border border-gray-200 rounded-lg shadow-lg sm:p-10">
            
            <div class="mb-6 text-center">
                <h2 class="text-3xl font-medium text-gray-500">
                    Log in to WorkHub
                </h2>
            </div>
            @if ($errors->has('loginError'))
                <div class="mb-4 text-xl font-medium text-red-500">
                    {{ $errors->first('loginError') }}
                </div>
            @endif
            
            <form class="space-y-4" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div>
                    <div class="relative">
                        <input
                            id="email"
                            name="email"
                            type="text"
                            required
                            placeholder="Email"
                            class="block w-full px-3 py-2 pl-10 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <img src="{{ asset('images/people.png') }}" alt="People" class="w-6 h-6">
                        </div>
                    </div>
                </div>

                <div>
                    <div class="relative">
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="Password"
                            class="block w-full px-3 py-2 pl-10 placeholder-gray-400 border border-gray-300 rounded-md shadow-sm appearance-none focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                        >
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <img src="{{ asset('images/padlock.png') }}" alt="People" class="w-5 h-5">
                        </div>
                    </div>
                </div>

                <div>
                    <button
                        type="submit"
                        class="flex justify-center w-full px-4 py-2 text-sm font-medium text-black transition duration-150 ease-in-out bg-blue-500 border border-transparent rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700"
                    >
                        Continue
                    </button>
                </div>
            </form>
            
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
            
            <div class="space-y-3">
                    <button
                    id="googleLoginBtn"
                    type="button"
                    class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <img src="{{ asset('images/google.png') }}" alt="People" class="w-5 h-5 mx-2">
                    Continue with Google
                </button>
            </div>
            
            <div class="my-8"></div>

            <div class="text-center">
                <p class="mb-4 text-sm text-gray-500">
                    Don't have an WorkHub account?
                </p>
                <a
                    href="/account_type"
                    class="inline-flex justify-center px-8 py-2 text-sm font-medium text-blue-500 transition duration-150 ease-in-out bg-white border border-blue-500 rounded-full shadow-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Sign Up
                </a>
            </div>

        </div>
    </main>
</body>
</html>

<script>
document.getElementById('googleLoginBtn').addEventListener('click', function () {

    let userType = prompt("Please select your login type:\nType 'client' or 'freelancer'");

    if (!userType) {
        alert("You must select a login type to continue.");
        return;
    }

    userType = userType.toLowerCase().trim();

    if (userType === 'client') {
        window.location.href = "/auth/google/client";
    } else if (userType === 'freelancer') {
        window.location.href = "/auth/google/freelancer";
    } else {
        alert("Invalid selection. Please type 'client' or 'freelancer'.");
    }
});
</script>

