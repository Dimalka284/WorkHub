@extends('layout.app')

@section('title', 'Welcome')

@section('content')

<!-- HERO WRAPPER -->
<div class="px-4 py-10 mx-auto max-w-7xl">

    <!-- Background Image Container -->
    <div class="relative rounded-[30px] overflow-hidden shadow-xl">

        <!-- Hero Image -->
        <img 
            src="{{ asset('images/mainimg.jpg') }}" 
            class="w-full h-[450px] md:h-[600px] object-cover"
        >

        <!-- Dark Overlay -->
        <div class="absolute inset-0 bg-black/40"></div>

        <!-- CONTENT -->
        <div class="absolute inset-0 flex flex-col justify-center px-6 md:px-16">

            <!-- Big Heading -->
            <h1 class="text-white font-extrabold text-4xl md:text-6xl leading-tight w-full md:w-[60%]">
                Connecting clients <br>
                in need to freelancers <br>
                who deliver
            </h1>

            <!-- Glass Card -->
            <div class="max-w-lg p-6 mt-8 border rounded-2xl bg-white/10 backdrop-blur-md border-white/20">

                <!-- Toggle Buttons -->
                <div class="flex p-1 space-x-2 rounded-full bg-black/20">

                    <button id="findTalentBtn"
                        class="flex-1 py-2 font-medium text-white transition rounded-full bg-white/20 hover:bg-white/30">
                        Find talent
                    </button>

                    <button id="browseJobsBtn"
                        class="flex-1 py-2 font-medium text-white transition border rounded-full border-white/30 hover:bg-white/20">
                        Browse jobs
                    </button>

                </div>

                <!-- Talent Section -->
                <div id="talentContent" class="mt-4 text-sm text-white">
                    Build your freelancing career on WorkHub, with 
                    thousands of jobs posted every week.

                    <button class="px-6 py-2 mt-4 font-semibold text-white bg-green-600 rounded-full shadow hover:bg-green-700">
                        Explore recently posted jobs
                    </button>
                </div>

                <!-- Jobs Section -->
                <div id="jobsContent" class="hidden mt-4 text-sm text-white">
                    100,000+ talented freelancers ready to work with you.

                    <div class="relative mt-4">
                        <input 
                            type="text" 
                            placeholder="Search talent…" 
                            class="w-full px-4 py-2 text-black rounded-full outline-none"
                        >
                        <button 
                            class="absolute px-4 py-1 text-sm text-white bg-blue-600 rounded-full right-1 top-1 hover:bg-blue-700">
                            Search
                        </button>
                    </div>
                </div>

            </div><!-- End card -->

        </div><!-- End content -->

    </div><!-- End bg -->

</div>

<!-- JS -->
<script>
    const findBtn = document.getElementById('findTalentBtn');
    const jobsBtn = document.getElementById('browseJobsBtn');
    const talent = document.getElementById('talentContent');
    const jobs = document.getElementById('jobsContent');

    findBtn.onclick = () => {
        findBtn.classList.add('bg-white/20');
        findBtn.classList.remove('border');
        jobsBtn.classList.remove('bg-white/20');
        jobsBtn.classList.add('border');

        talent.classList.remove('hidden');
        jobs.classList.add('hidden');
    };

    jobsBtn.onclick = () => {
        jobsBtn.classList.add('bg-white/20');
        jobsBtn.classList.remove('border');
        findBtn.classList.remove('bg-white/20');
        findBtn.classList.add('border');

        jobs.classList.remove('hidden');
        talent.classList.add('hidden');
    };
</script>

@endsection
