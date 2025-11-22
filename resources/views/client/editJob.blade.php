@extends('layout.app')

@section('title', 'Edit Job')

@section('content')
<div class="max-w-3xl p-8 mx-auto bg-white shadow-2xl rounded-2xl">
    
    <h2 class="pb-3 mb-8 text-3xl font-extrabold text-gray-900 border-b">
        Edit Job Post
    </h2>

    <form action="{{ route('client.job.update', $job->jobPostId) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-2">
            <label for="title" class="block text-lg font-semibold text-gray-700">Job Title</label>
            <input type="text" id="title" name="title" value="{{ $job->title }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>
        </div>

        <div class="space-y-2">
            <label for="description" class="block text-lg font-semibold text-gray-700">Description</label>
            <textarea id="description" name="description" rows="6"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>{{ $job->description }}</textarea>
        </div>

        <div class="space-y-2">
            <label for="category" class="block text-lg font-semibold text-gray-700">Category</label>
            <select id="category" name="category" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>
                <option value="" disabled>Select a Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->categoryId }}"
                        @if($category->categoryId == $job->category_id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="space-y-2">
            <label for="skills-select" class="block text-lg font-semibold text-gray-700">Skills</label>
            <select id="skills-select" name="skills[]" multiple class="w-full">
                @foreach($skills as $skill)
                    <option value="{{ $skill->skillId }}"
                        @if($job->skills->pluck('skillId')->contains($skill->skillId)) selected @endif>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            
            <div class="space-y-2">
                <label for="scope" class="block text-lg font-semibold text-gray-700">Project Length</label>
                <select id="scope" name="scope" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>
                    <option value="1 Week" @if($job->project_length == '1 Week') selected @endif>1 Week</option>
                    <option value="2 Weeks" @if($job->project_length == '2 Weeks') selected @endif>2 Weeks</option>
                    <option value="1 Month" @if($job->project_length == '1 Month') selected @endif>1 Month</option>
                    <option value="2 Months" @if($job->project_length == '2 Months') selected @endif>2 Months</option>
                    <option value="3+ Months" @if($job->project_length == '3+ Months') selected @endif>3+ Months</option>
                </select>
            </div>

            <div class="space-y-2">
                <label for="paymenttype" class="block text-lg font-semibold text-gray-700">Payment Preference</label>
                <select id="paymenttype" name="paymenttype" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>
                    <option value="Hourly" @if($job->paymenttype == 'Hourly') selected @endif>Hourly</option>
                    <option value="Fixed" @if($job->paymenttype == 'Fixed') selected @endif>Fixed</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">

            <div class="space-y-2">
                <label for="budget" class="block text-lg font-semibold text-gray-700">Budget (Rs)</label>
                <input type="number" id="budget" name="budget" value="{{ $job->budget }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>
            </div>
            
            <div class="space-y-2">
                <label for="deadline" class="block text-lg font-semibold text-gray-700">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ $job->deadline ? $job->deadline->format('Y-m-d') : '' }}"
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-4 focus:ring-teal-500 focus:border-teal-500 transition duration-150" required>
            </div>
        </div>

        <button type="submit" class="w-full py-3 mt-6 text-xl font-bold text-white transition duration-200 bg-green-500 rounded-xl hover:bg-green-600 focus:outline-none focus:ring-4 focus:ring-green-300">
            Update Job
        </button>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect("#skills-select", {
            plugins: ['remove_button'],
            create: false,
            persist: false,
            maxItems: null,
            placeholder: "Select one or more skills...",
            render: {
                option: function(data, escape) {
                    return `<div class='px-2 py-1 text-base'>${escape(data.text)}</div>`;
                },
                item: function(data, escape) {
                    return `<div class='flex items-center px-3 py-1 mb-1 mr-1 space-x-1 text-sm font-medium text-teal-800 bg-teal-100 rounded-full'>
                                <span>${escape(data.text)}</span>
                            </div>`;
                }
            },
            onInitialize: function() {
                this.wrapper.querySelector('.ts-control').classList.add('px-4', 'py-1', 'border', 'border-gray-300', 'rounded-xl', 'focus:ring-4', 'focus:ring-teal-500', 'focus:border-teal-500', 'transition', 'duration-150');
            }
        });
    });
</script>
@endsection