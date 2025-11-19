<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - WorkHub Clone</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        window.ALL_SKILLS = @json($skills);
    </script>
    <script src="{{ asset('Javascript/jobpost_skills.js') }}" defer></script>

    <style>
        .workhub-blue { background-color: #2563eb; }
        .workhub-blue:hover { background-color: #1d4ed8; }
        .workhub-blue-outline { border-color: #2563eb; color: #2563eb; }
        .workhub-blue-outline:hover { background-color: #eff6ff; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<header class="flex justify-between items-center p-6 border-b bg-white">
    <div class="text-2xl font-bold">
        <span class="text-blue-600">Work</span>Hub
    </div>
    <div class="text-gray-700 text-xl font-medium">
        Welcome, {{ session('clientFirstName') }}
    </div>
</header>

<main class="flex justify-center py-10 px-4">
    <div class="w-full max-w-4xl bg-white p-8 shadow-lg rounded-lg border">

        <div class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-semibold text-gray-900">
                Post a New Job
            </h1>
            <p class="text-gray-500 mt-1">
                Describe the project clearly to attract the best talent.
            </p>
        </div>

        <form action="{{ route('jobpost') }}" method="POST">
            @csrf
            <div id="step1" class="space-y-8">
                <h2 class="text-xl font-medium border-b pb-2">
                    Step 1: Project Details
                </h2>

                
                <div>
                    <label class="block text-sm font-medium">
                        Write a title for your job post
                    </label>
                    <input name="title" type="text" required
                        class="mt-1 block w-full px-4 py-2 border rounded-lg">

                    <p class="text-s text-gray-500 mt-2">Example titles:</p>
                    <p class="text-xs ml-4 text-gray-700 my-0.5">Design a Modern Logo for a Startup Brand</p>
                    <p class="text-xs ml-4 text-gray-700 my-0.5">Build a Responsive Portfolio Website using HTML, CSS, and JavaScript</p>
                    <p class="text-xs ml-4 text-gray-700 my-0.5">Develop a Simple Login and Registration System using C# and MySQL</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium">
                        Job Description
                    </label>
                    <textarea name="description" rows="8" required
                        placeholder="Describe your project, required skills, deliverables, and timeline here..."
                        class="mt-1 block w-full px-4 py-2 border rounded-lg"></textarea>
                </div>

                <hr>

                <h2 class="text-xl font-medium border-b pb-2">
                    Step 2: Requirements & Scope
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium">Category</label>
                        <select name="category" required class="mt-1 block w-full border rounded-lg p-2">
                            @foreach($categories as $category)
                            <option value="{{ $category->categoryId }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Project Length</label>
                        <select name="scope" required class="mt-1 block w-full border rounded-lg p-2">
                            <option>Less than 1 month</option>
                            <option>1 to 3 months</option>
                            <option>3 to 6 months</option>
                            <option>More than 6 months</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium">Required Skills</label>

                    <input id="skills-search" type="text" placeholder="Search skills or add your own"
                        class="mt-1 block w-full px-4 py-2 border rounded-lg">

                    <p class="text-sm text-gray-500 mt-2">For the best results, add 3-5 skills</p>

                    <div id="selected-skills-container"
                        class="flex flex-wrap gap-2 mt-3 border border-dashed p-2 rounded-lg min-h-[40px]"></div>

                    <input type="hidden" id="selectedskillsdata" name="selectedskillsdata">

                    <h3 class="text-base font-semibold mt-6 mb-2">Popular skills for Web Development</h3>
                    <div id="suggested-skills-container" class="flex flex-wrap gap-3"></div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" id="nextBtn"
                        class="py-2 px-6 border workhub-blue-outline rounded-full">
                        Next
                    </button>
                </div>
            </div>

            <div id="step2" class="space-y-8 hidden">

                <h2 class="text-xl font-medium border-b pb-2">
                    Step 3: Budget & Terms
                </h2>

                <div class="p-4 border rounded-lg bg-blue-50 border-blue-500">
                    <p class="font-semibold text-gray-800 flex items-center">
                        <img src="{{ asset('images/pricing.png') }}" class="w-10 h-10 mr-2">
                        Fixed Price
                    </p>
                    <p class="text-xs text-gray-500 mt-1">
                        You will pay one set amount for the entire project.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Enter Project Budget (LKR)</label>
                    <input type="number" name="budget" required
                        class="mt-1 block w-full px-4 py-2 border rounded-lg"
                        placeholder="Enter amount e.g. 1500">
                </div>

                <div>
                    <label class="block text-sm font-medium">Payment Preference</label>
                    <select name="paymenttype" required
                        class="mt-1 block w-full border rounded-lg p-2">
                        <option>Payment upon 100% completion</option>
                        <option>Milestone payments (e.g., 25% at design, 75% at delivery)</option>
                    </select>
                </div>

                <hr>

                <!-- Buttons -->
                <div class="flex justify-between">
                    <button type="button" id="backBtn"
                        class="py-2 px-6 border workhub-blue-outline rounded-full">
                        Back to Requirements
                    </button>

                    <button type="submit"
                        class="py-2 px-6 rounded-full text-white workhub-blue">
                        Review and Post Job
                    </button>
                </div>
            </div>

        </form>
        @if ($errors->any())
<div class="bg-red-100 text-red-700 p-3 rounded my-3">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    </div>
</main>

<script>
    // Step switching logic
    document.getElementById("nextBtn").onclick = function () {
        document.getElementById("step1").classList.add("hidden");
        document.getElementById("step2").classList.remove("hidden");
    };

    document.getElementById("backBtn").onclick = function () {
        document.getElementById("step2").classList.add("hidden");
        document.getElementById("step1").classList.remove("hidden");
    };
</script>

</body>
</html>
