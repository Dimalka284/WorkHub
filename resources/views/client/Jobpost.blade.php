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
<body class="min-h-screen bg-gray-50">

<header class="flex items-center justify-between p-6 bg-white border-b">
    <div class="text-2xl font-bold">
        <span class="text-blue-600">Work</span>Hub
    </div>
    <div class="text-xl font-medium text-gray-700">
        Welcome, {{ session('clientFirstName') }}
    </div>
</header>

<main class="flex justify-center px-4 py-10">
    <div class="w-full max-w-4xl p-8 bg-white border rounded-lg shadow-lg">

        <div class="pb-4 mb-8 border-b">
            <h1 class="text-3xl font-semibold text-gray-900">
                Post a New Job
            </h1>
            <p class="mt-1 text-gray-500">
                Describe the project clearly to attract the best talent.
            </p>
        </div>

        <form action="{{ route('jobpost') }}" method="POST">
            @csrf
            <div id="step1" class="space-y-8">
                <h2 class="pb-2 text-xl font-medium border-b">
                    Step 1: Project Details
                </h2>

                <!-- Step 1 Error Messages -->
                <div id="step1-errors" class="hidden p-3 mb-4 text-red-700 bg-red-100 rounded"></div>

                <div>
                    <label class="block text-sm font-medium">
                        Write a title for your job post
                    </label>
                    <input id="job-title" name="title" type="text" required
                        class="block w-full px-4 py-2 mt-1 border rounded-lg">

                    <p class="mt-2 text-gray-500 text-s">Example titles:</p>
                    <p class="text-xs ml-4 text-gray-700 my-0.5">Design a Modern Logo for a Startup Brand</p>
                    <p class="text-xs ml-4 text-gray-700 my-0.5">Build a Responsive Portfolio Website using HTML, CSS, and JavaScript</p>
                    <p class="text-xs ml-4 text-gray-700 my-0.5">Develop a Simple Login and Registration System using C# and MySQL</p>
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium">
                        Job Description
                    </label>
                    <textarea id="job-description" name="description" rows="8" required
                        placeholder="Describe your project, required skills, deliverables, and timeline here..."
                        class="block w-full px-4 py-2 mt-1 border rounded-lg"></textarea>
                </div>

                <hr>

                <h2 class="pb-2 text-xl font-medium border-b">
                    Step 2: Requirements & Scope
                </h2>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium">Category</label>
                        <select name="category" required class="block w-full p-2 mt-1 border rounded-lg">
                            @foreach($categories as $category)
                            <option value="{{ $category->categoryId }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium">Project Length</label>
                        <select name="scope" required class="block w-full p-2 mt-1 border rounded-lg">
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
                        class="block w-full px-4 py-2 mt-1 border rounded-lg">

                    <p class="mt-2 text-sm text-gray-500">For the best results, add 3-5 skills</p>

                    <div id="selected-skills-container"
                        class="flex flex-wrap gap-2 mt-3 border border-dashed p-2 rounded-lg min-h-[40px]"></div>

                    <input type="hidden" id="selectedskillsdata" name="selectedskillsdata">

                    <h3 class="mt-6 mb-2 text-base font-semibold">Popular skills for Web Development</h3>
                    <div id="suggested-skills-container" class="flex flex-wrap gap-3"></div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" id="nextBtn"
                        class="px-6 py-2 border rounded-full workhub-blue-outline">
                        Next
                    </button>
                </div>
            </div>

            <div id="step2" class="hidden space-y-8">

                <h2 class="pb-2 text-xl font-medium border-b">
                    Step 3: Budget & Terms
                </h2>

                <div class="p-4 border border-blue-500 rounded-lg bg-blue-50">
                    <p class="flex items-center font-semibold text-gray-800">
                        <img src="{{ asset('images/pricing.png') }}" class="w-10 h-10 mr-2">
                        Fixed Price
                    </p>
                    <p class="mt-1 text-xs text-gray-500">
                        You will pay one set amount for the entire project.
                    </p>
                </div>

                <div>
                    <label class="block text-sm font-medium">Enter Project Budget (LKR)</label>
                    <input type="number" name="budget" required
                        class="block w-full px-4 py-2 mt-1 border rounded-lg"
                        placeholder="Enter amount e.g. 1500">
                </div>

                <div>
                    <label class="block text-sm font-medium">Payment Preference</label>
                    <select name="paymenttype" required
                        class="block w-full p-2 mt-1 border rounded-lg">
                        <option>Payment upon 100% completion</option>
                        <option>Milestone payments (e.g., 25% at design, 75% at delivery)</option>
                    </select>
                </div>
                <label class="block mb-3">
                    <span class="font-semibold">Deadline</span>
                    <input type="date" name="deadline" class="w-full mt-1 border-gray-300 rounded-md" required>
                </label>

                <hr>

                <div class="flex justify-between">
                    <button type="button" id="backBtn"
                        class="px-6 py-2 border rounded-full workhub-blue-outline">
                        Back to Requirements
                    </button>

                    <button type="submit"
                        class="px-6 py-2 text-white rounded-full workhub-blue">
                        Review and Post Job
                    </button>
                </div>
            </div>

        </form>

        @if ($errors->any())
        <div class="p-3 my-3 text-red-700 bg-red-100 rounded">
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
document.getElementById("nextBtn").onclick = function () {
    const title = document.getElementById("job-title").value.trim();
    const description = document.getElementById("job-description").value.trim();
    const skills = document.getElementById("selectedskillsdata").value.trim();

    const errorContainer = document.getElementById("step1-errors");
    errorContainer.innerHTML = "";

    let errors = [];

    if (!title) errors.push("Please enter a job title.");
    if (!description) errors.push("Please enter a job description.");
    if (!skills) errors.push("Please select at least one skill.");

    if (errors.length > 0) {
        errorContainer.classList.remove("hidden");
        errors.forEach(msg => {
            const p = document.createElement("p");
            p.textContent = msg;
            errorContainer.appendChild(p);
        });
        return; 
    }

    errorContainer.classList.add("hidden");
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
