<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Post a Job - WorkHub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        window.ALL_SKILLS = @json($skills);
    </script>
    <script src="{{ asset('Javascript/jobpost_skills.js') }}" defer></script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 50%, rgba(120, 119, 198, 0.3), transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(138, 43, 226, 0.3), transparent 50%),
                radial-gradient(circle at 40% 20%, rgba(72, 149, 239, 0.3), transparent 50%);
            pointer-events: none;
            z-index: 0;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transition: left 0.3s ease;
        }

        .btn-primary:hover::before {
            left: 0;
        }

        .btn-primary span {
            position: relative;
            z-index: 1;
        }

        .btn-secondary {
            border: 2px solid #667eea;
            color: #667eea;
            background: white;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .input-field {
            border: 2px solid #e5e7eb;
            transition: all 0.3s ease;
            background: white;
        }

        .input-field:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .skill-tag {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
        }

        .skill-tag:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .step-indicator {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 700;
            font-size: 18px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .step-indicator.inactive {
            background: #e5e7eb;
            color: #9ca3af;
            box-shadow: none;
        }

        .step-line {
            height: 3px;
            flex: 1;
            background: #e5e7eb;
            margin: 0 16px;
        }

        .step-line.active {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .section-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        .section-card:hover {
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.1);
            transform: translateY(-2px);
        }

        .error-container {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border-left: 4px solid #ef4444;
        }

        .info-box {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            border-left: 4px solid #3b82f6;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease;
        }

        .example-text {
            transition: all 0.2s ease;
        }

        .example-text:hover {
            color: #667eea;
            transform: translateX(4px);
        }
    </style>
</head>
<body>

<header class="glass-header fixed top-0 left-0 right-0 z-50 flex items-center justify-between p-6">
    <div class="text-3xl font-bold">
        <span class="gradient-text">Work</span><span class="text-gray-800">Hub</span>
    </div>
    <div class="flex items-center space-x-4">
        <div class="text-lg font-medium text-gray-700">
            Welcome, <span class="gradient-text font-semibold">{{ session('clientFirstName') }}</span>
        </div>
    </div>
</header>

<main class="relative z-10 flex justify-center px-4 py-10 mt-24">
    <div class="w-full max-w-5xl">
        
        <!-- Step Progress Indicator -->
        <div class="glass-container p-6 mb-8 rounded-2xl fade-in">
            <div class="flex items-center justify-center">
                <div class="flex items-center">
                    <div id="step-indicator-1" class="step-indicator">1</div>
                    <div id="step-line-1" class="step-line"></div>
                    <div id="step-indicator-2" class="step-indicator inactive">2</div>
                </div>
            </div>
            <div class="flex justify-between mt-4 text-center">
                <div class="flex-1">
                    <p id="step-label-1" class="font-semibold gradient-text">Project Details</p>
                </div>
                <div class="flex-1">
                    <p id="step-label-2" class="font-semibold text-gray-400">Budget & Terms</p>
                </div>
            </div>
        </div>

        <div class="glass-container p-10 rounded-3xl fade-in">
            <div class="pb-6 mb-8 border-b-2 border-gray-100">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">
                    Post a New <span class="gradient-text">Job</span>
                </h1>
                <p class="text-lg text-gray-600">
                    Describe your project clearly to attract the best talent
                </p>
            </div>

            <form action="{{ route('jobpost') }}" method="POST">
                @csrf
                <div id="step1" class="space-y-6">
                    
                    <!-- Step 1 Error Messages -->
                    <div id="step1-errors" class="hidden error-container p-4 rounded-xl"></div>

                    <div class="section-card">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            📝 Write a title for your job post
                        </label>
                        <input id="job-title" name="title" type="text" required
                            class="input-field block w-full px-5 py-3 rounded-xl text-base"
                            placeholder="e.g., Build a Responsive Portfolio Website">

                        <div class="mt-4 p-4 bg-gray-50 rounded-xl">
                            <p class="text-sm font-semibold text-gray-700 mb-2">💡 Example titles:</p>
                            <p class="example-text text-sm text-gray-600 ml-4 my-1.5">• Design a Modern Logo for a Startup Brand</p>
                            <p class="example-text text-sm text-gray-600 ml-4 my-1.5">• Build a Responsive Portfolio Website using HTML, CSS, and JavaScript</p>
                            <p class="example-text text-sm text-gray-600 ml-4 my-1.5">• Develop a Simple Login and Registration System using C# and MySQL</p>
                        </div>
                    </div>

                    <div class="section-card">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            📄 Job Description
                        </label>
                        <textarea id="job-description" name="description" rows="8" required
                            placeholder="Describe your project, required skills, deliverables, and timeline here..."
                            class="input-field block w-full px-5 py-3 rounded-xl text-base resize-none"></textarea>
                    </div>

                    <div class="section-card">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 gradient-text">
                            Requirements & Scope
                        </h2>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">🏷️ Category</label>
                                <select name="category" required class="input-field block w-full px-5 py-3 rounded-xl text-base">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->categoryId }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">⏱️ Project Length</label>
                                <select name="scope" required class="input-field block w-full px-5 py-3 rounded-xl text-base">
                                    <option>Less than 1 month</option>
                                    <option>1 to 3 months</option>
                                    <option>3 to 6 months</option>
                                    <option>More than 6 months</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">🎯 Required Skills</label>

                            <input id="skills-search" type="text" placeholder="Search skills or add your own"
                                class="input-field block w-full px-5 py-3 rounded-xl text-base">

                            <p class="mt-3 text-sm text-gray-600 bg-blue-50 p-3 rounded-lg">
                                💡 For the best results, add 3-5 skills
                            </p>

                            <div id="selected-skills-container"
                                class="flex flex-wrap gap-3 mt-4 border-2 border-dashed border-gray-200 p-4 rounded-xl min-h-[60px] bg-gray-50"></div>

                            <input type="hidden" id="selectedskillsdata" name="selectedskillsdata">

                            <h3 class="mt-6 mb-3 text-base font-bold text-gray-800">Popular skills for Web Development</h3>
                            <div id="suggested-skills-container" class="flex flex-wrap gap-3"></div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4">
                        <button type="button" id="nextBtn"
                            class="btn-secondary px-8 py-3 rounded-full font-semibold text-base">
                            Next: Budget & Terms →
                        </button>
                    </div>
                </div>

                <div id="step2" class="hidden space-y-6">

                    <div class="section-card">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 gradient-text">
                            Budget & Terms
                        </h2>

                        <div class="info-box p-5 rounded-xl mb-6">
                            <p class="flex items-center font-semibold text-gray-800 text-lg">
                                <img src="{{ asset('images/pricing.png') }}" class="w-12 h-12 mr-3">
                                Fixed Price Project
                            </p>
                            <p class="mt-2 text-sm text-gray-600 ml-15">
                                You will pay one set amount for the entire project.
                            </p>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">💰 Enter Project Budget (LKR)</label>
                            <input type="number" name="budget" required
                                class="input-field block w-full px-5 py-3 rounded-xl text-base"
                                placeholder="Enter amount e.g. 15000">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">💳 Payment Preference</label>
                            <select name="paymenttype" required
                                class="input-field block w-full px-5 py-3 rounded-xl text-base">
                                <option>Payment upon 100% completion</option>
                                <option>Milestone payments (e.g., 25% at design, 75% at delivery)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">📅 Deadline</label>
                            <input type="date" name="deadline" required
                                class="input-field block w-full px-5 py-3 rounded-xl text-base">
                        </div>
                    </div>

                    <div class="flex justify-between pt-4">
                        <button type="button" id="backBtn"
                            class="btn-secondary px-8 py-3 rounded-full font-semibold text-base">
                            ← Back to Requirements
                        </button>

                        <button type="submit"
                            class="btn-primary px-8 py-3 text-white rounded-full font-semibold text-base">
                            <span>Review and Post Job ✨</span>
                        </button>
                    </div>
                </div>

            </form>

            @if ($errors->any())
            <div class="error-container p-4 my-4 rounded-xl">
                <p class="font-semibold mb-2">⚠️ Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </div>
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
        errorContainer.innerHTML = '<p class="font-semibold mb-2">⚠️ Please fix the following:</p>';
        errors.forEach(msg => {
            const p = document.createElement("p");
            p.textContent = "• " + msg;
            p.className = "text-sm ml-4";
            errorContainer.appendChild(p);
        });
        errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return; 
    }

    errorContainer.classList.add("hidden");
    
    // Update step indicators
    document.getElementById("step-indicator-1").classList.add("inactive");
    document.getElementById("step-indicator-2").classList.remove("inactive");
    document.getElementById("step-line-1").classList.add("active");
    document.getElementById("step-label-1").classList.remove("gradient-text");
    document.getElementById("step-label-1").classList.add("text-gray-400");
    document.getElementById("step-label-2").classList.remove("text-gray-400");
    document.getElementById("step-label-2").classList.add("gradient-text");
    
    document.getElementById("step1").classList.add("hidden");
    document.getElementById("step2").classList.remove("hidden");
    document.getElementById("step2").classList.add("fade-in");
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

document.getElementById("backBtn").onclick = function () {
    // Update step indicators
    document.getElementById("step-indicator-1").classList.remove("inactive");
    document.getElementById("step-indicator-2").classList.add("inactive");
    document.getElementById("step-line-1").classList.remove("active");
    document.getElementById("step-label-1").classList.add("gradient-text");
    document.getElementById("step-label-1").classList.remove("text-gray-400");
    document.getElementById("step-label-2").classList.add("text-gray-400");
    document.getElementById("step-label-2").classList.remove("gradient-text");
    
    document.getElementById("step2").classList.add("hidden");
    document.getElementById("step1").classList.remove("hidden");
    document.getElementById("step1").classList.add("fade-in");
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

</body>
</html>
