<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join as a client or freelancer - Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen">

    <header class="p-6">
        <div class="text-2xl font-bold text-black tracking-tighter">
            <span class="text-blue-600">Work</span>Hub
        </div>
    </header>

    <main class="flex flex-col items-center justify-center pt-10 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg">
            
            <div class="text-center mb-8">
                <h2 class="text-3xl font-normal text-gray-800">
                    Sri Lanka
                </h2>
                <h2 class="text-3xl font-normal text-gray-800">
                    Join as a client or freelancer
                </h2>
            </div>
            
            <form id="joinForm" class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6 mb-8">
                
                <div>
                    <label for="client" class="cursor-pointer block">
                        <div class="card-border w-full h-full p-6 border-2 border-gray-200 hover:border-blue-500 rounded-lg transition duration-150 ease-in-out text-center">
                            <div class="flex justify-between items-start mb-4">
                                <img src="{{ asset('images/client.png') }}" alt="People" class="w-10 h-10 mx-2">
                                <input type="radio" id="client" name="user_type" value="client" checked>
                            </div>
                            <p class="text-lg font-medium text-gray-700">
                                I'm a client, hiring for a project
                            </p>
                        </div>
                    </label>
                </div>

                <div>
                    <label for="freelancer" class="cursor-pointer block">
                        <div class="card-border w-full h-full p-6 border-2 border-gray-200 hover:border-blue-500 rounded-lg transition duration-150 ease-in-out text-center">
                            <div class="flex justify-between items-start mb-4">
                                <img src="{{ asset('images/freelancer.png') }}" alt="People" class="w-10 h-10 mx-2">
                                <input type="radio" id="freelancer" name="user_type" value="freelancer">
                            </div>
                            <p class="text-lg font-medium text-gray-700">
                                I'm a freelancer, looking for work
                            </p>
                        </div>
                    </label>
                </div>
            </form>

            <div class="text-center mb-6">
                <button
                    type="button"
                    id="createAccountBtn"
                    class="py-2 px-10 border border-transparent rounded-full shadow-sm text-sm font-medium text-gray-500 bg-gray-200 hover:bg-gray-300"
                >
                    Create Account
                </button>
            </div>
            
            <div class="text-center">
                <p class="text-sm text-gray-500">
                    Already have an account? 
                    <a href="login" class="text-blue-600 font-medium hover:text-blue-900">
                        Log In
                    </a>
                </p>
            </div>

        </div>
    </main>

    <script>
        document.getElementById('createAccountBtn').addEventListener('click', function() {
            const selectedType = document.querySelector('input[name="user_type"]:checked').value;

            if (selectedType === 'client') {
                window.location.href = '/client_ac';
            } else if (selectedType === 'freelancer') {
                window.location.href = '/freelancer_ac';
            }
        });
    </script>
</body>
</html>
