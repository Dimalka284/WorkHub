<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>WorkHub — Edit Profile</title>


  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --accent-start: #0ea5e9;
      --accent-end: #0f172a;
      --glass-bg: rgba(255,255,255,0.65);
      --glass-border: rgba(14,165,233,0.12);
      --blur: 8px;
      --card-radius: 14px;
    }
    body { font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background: linear-gradient(180deg,#f8fafc 0%, #eef2ff 100%); }

    /* glass card */
    .glass {
      background: linear-gradient(180deg, rgba(255,255,255,0.72), rgba(255,255,255,0.6));
      border: 1px solid var(--glass-border);
      backdrop-filter: blur(var(--blur));
    }

    /* subtle gradient for primary buttons */
    .btn-primary {
      background: linear-gradient(90deg,var(--accent-start), #0066a8);
    }

    .progress-fill { transition: width 450ms cubic-bezier(.2,.9,.3,1); }
    .tag {
      background: rgba(14,165,233,0.08);
      border: 1px solid rgba(14,165,233,0.12);
      color: #075985;
    }
    .focus-accent:focus { outline: none; box-shadow: 0 0 0 4px rgba(14,165,233,0.12); border-color: #06b6d4; }
  </style>
</head>
<body class="antialiased text-slate-800">

  <div class="flex items-start justify-center min-h-screen px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-4xl">

      <!-- Header -->
      <header class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
          <div>
            <div class="text-3xl font-semibold">Work<span class="text-blue-600">Hub</span></div>
            <div class="text-xl text-slate-500">Edit your profile — keep it fresh and up-to-date</div>
          </div>
        </div>

        <div class="items-center hidden gap-4 text-sm text-slate-500 sm:flex">
          <a href="{{ route('gig.details', $gig->id) }}" class="px-3 py-2 text-sm border rounded-md border-slate-200 hover:bg-slate-50">Cancel</a>
        </div>
      </header>

      <main class="glass rounded-[14px] shadow-lg p-6 sm:p-8">

        <!-- Top progress -->
        <div class="mb-6">
          <div class="flex items-center justify-between">
            <div>
              <div class="text-lg font-medium text-slate-600">Profile update</div>
              <div class="text-lg text-slate-400">2 steps • make your changes</div>
            </div>
            <div class="text-sm text-slate-500">Step <span id="ui-step-label" class="font-semibold">1</span>/2</div>
          </div>

          <div class="w-full h-2 mt-3 overflow-hidden rounded-full bg-slate-100">
            <div id="progress" class="w-1/4 h-2 progress-fill bg-gradient-to-r from-sky-500 to-blue-700"></div>
          </div>

          <div class="flex items-center gap-3 mt-3 text-sm">
            <div class="flex items-center gap-2">
              <div id="dot-1" class="flex items-center justify-center font-medium bg-white border rounded-full w-7 h-7 border-slate-200 text-slate-700">1</div>
              <div class="text-slate-600">Personal</div>
            </div>
            <div class="flex items-center gap-2">
              <div id="dot-2" class="flex items-center justify-center font-medium border rounded-full w-7 h-7 bg-slate-50 border-slate-200 text-slate-400">2</div>
              <div class="text-slate-600">Professional</div>
            </div>
          </div>
        </div>

        <form id="profileForm" action="{{ route('gig.update', $gig->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6">
          @csrf
          @method('PUT')
          <section id="step-1" class="space-y-6">

            <div class="grid items-center grid-cols-1 gap-4 sm:grid-cols-3">
              <label class="text-sm text-slate-700">Display name <span class="text-red-500">*</span></label>
              <div class="sm:col-span-2">
                <input name="displayname" id="displayname" type="text"
                       value="{{ old('displayname', $gig->display_name) }}"
                       placeholder="e.g. john_designs"
                       class="w-full p-3 border rounded-lg border-slate-200 focus-accent" />
                <div class="mt-2 text-xs text-slate-400">This is the name buyers will see prominently on your profile.</div>
              </div>
            </div>

            <div class="grid items-start grid-cols-1 gap-4 sm:grid-cols-3">
              <label class="text-sm text-slate-700">Profile photo</label>
              <div class="sm:col-span-2">
                <div class="flex items-center gap-4">
                  <div id="avatarPreview" class="flex items-center justify-center overflow-hidden text-3xl border w-28 h-28 rounded-xl bg-slate-50 border-slate-200 text-slate-400">
                    @if($gig->profileimg)
                      <img src="{{ asset('storage/' . $gig->profileimg) }}" alt="Profile" class="object-cover w-full h-full" id="currentAvatar">
                    @else
                      <span id="avatarInitial">{{ substr($gig->display_name, 0, 1) }}</span>
                    @endif
                  </div>

                  <div class="flex-1">
                    <label class="block">
                      <input name="profileimg" id="profileimg" type="file" accept="image/*" class="hidden" />
                      <button type="button" id="uploadBtn" class="px-4 py-2 text-white rounded-md shadow-sm btn-primary hover:opacity-95">Change photo</button>
                    </label>
                    <div class="mt-2 text-xs text-slate-400">Square image, at least 400×400px recommended.</div>
                    <div class="mt-1 text-xs text-slate-400">Supported: JPG, PNG (max 5MB)</div>
                    <div class="mt-1 text-xs text-slate-500">Leave empty to keep current photo</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="grid items-start grid-cols-1 gap-4 sm:grid-cols-3">
              <label class="pt-2 text-sm text-slate-700">Short bio <span class="text-red-500">*</span></label>
              <div class="sm:col-span-2">
                <textarea name="description" id="description" rows="5"
                          placeholder="Tell a bit about your experience, area of expertise and notable projects."
                          class="w-full p-3 border rounded-lg resize-none border-slate-200 focus-accent">{{ old('description', $gig->description) }}</textarea>

                <div class="flex items-center justify-between mt-2 text-xs text-slate-400">
                  <div id="desc-min">Minimum 150 characters</div>
                  <div><span id="desc-count">{{ strlen($gig->description) }}</span>/600</div>
                </div>
              </div>
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
              <div class="text-sm text-slate-500">All fields marked * are required.</div>
              <button type="button" id="to-step-2"
                      class="px-4 py-2 text-white rounded-md shadow btn-primary hover:opacity-95">
                Continue
              </button>
            </div>

          </section>

          <!-- STEP 2 -->
          <section id="step-2" class="hidden space-y-6">

            <div class="grid items-start grid-cols-1 gap-4 sm:grid-cols-3">
              <label class="pt-2 text-sm text-slate-700">Skills & experience <span class="text-red-500">*</span></label>

              <div class="sm:col-span-2">
                <div class="flex gap-2">
                  <select id="skillInput" class="flex-1 p-3 border rounded-lg border-slate-200 focus-accent">
                      <option value="">Select a skill</option>
                      @foreach($skills as $skill)
                          <option value="{{ $skill->skillId }}" data-name="{{ $skill->name }}">{{ $skill->name }}</option>
                      @endforeach
                  </select>

                  <select id="skillExp" class="p-3 border rounded-lg border-slate-200 focus-accent">
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate" selected>Intermediate</option>
                    <option value="Expert">Expert</option>
                  </select>

                  <button id="addSkillBtn" type="button" class="px-4 py-2 text-white rounded-md shadow btn-primary">
                    Add
                  </button>
                </div>

                <div id="skillTags" class="flex flex-wrap gap-2 mt-4"></div>

                <div class="mt-2 text-xs text-slate-400">Add up to 12 skills. Each skill can have its experience level.</div>
              </div>
            </div>

            <div class="grid items-start grid-cols-1 gap-4 sm:grid-cols-3">
              <label class="pt-2 text-sm text-slate-700">Education</label>
              <div class="sm:col-span-2">
                <input name="college" id="college" type="text"
                       value="{{ old('college', $gig->college) }}"
                       placeholder="College / University (optional)"
                       class="w-full p-3 border rounded-lg border-slate-200 focus-accent" />
              </div>
            </div>

            <div class="grid items-start grid-cols-1 gap-4 sm:grid-cols-3">
              <label class="pt-2 text-sm text-slate-700">Linked accounts</label>
              <div class="grid grid-cols-1 gap-3 sm:col-span-2">
                <input name="linkedin" id="linkedin" type="url"
                       value="{{ old('linkedin', $gig->linkedin) }}"
                       placeholder="LinkedIn profile URL"
                       class="w-full p-3 border rounded-lg border-slate-200 focus-accent" />

                <input name="git" id="git" type="url"
                       value="{{ old('git', $gig->git) }}"
                       placeholder="GitHub / portfolio URL"
                       class="w-full p-3 border rounded-lg border-slate-200 focus-accent" />
              </div>
            </div>

            <div class="flex items-center justify-between gap-3 pt-2">
              <div class="text-sm text-slate-500">Review and submit your changes.</div>

              <div class="flex items-center gap-3">
                <button type="button" id="back-to-1"
                        class="px-4 py-2 bg-white border rounded-md border-slate-200 text-slate-700">
                  Back
                </button>

                <button type="submit" id="submitBtn"
                        class="px-4 py-2 text-white rounded-md shadow btn-primary">
                  Update profile
                </button>
              </div>
            </div>

          </section>

        </form>

      </main>

      <footer class="mt-5 text-xs text-center text-slate-400">
        Editing: <span id="previewName" class="font-medium">{{ $gig->display_name }}</span>
      </footer>
    </div>
  </div>

  <script>
    // Elements
    const step1 = document.getElementById('step-1');
    const step2 = document.getElementById('step-2');
    const toStep2Btn = document.getElementById('to-step-2');
    const backTo1Btn = document.getElementById('back-to-1');
    const progressEl = document.getElementById('progress');
    const uiStepLabel = document.getElementById('ui-step-label');
    const dot1 = document.getElementById('dot-1');
    const dot2 = document.getElementById('dot-2');
    const desc = document.getElementById('description');
    const descCount = document.getElementById('desc-count');
    const descMin = document.getElementById('desc-min');

    const avatarPreview = document.getElementById('avatarPreview');
    const avatarInitial = document.getElementById('avatarInitial');
    const uploadBtn = document.getElementById('uploadBtn');
    const profileimg = document.getElementById('profileimg');

    const skillInput = document.getElementById('skillInput');
    const skillExp = document.getElementById('skillExp');
    const addSkillBtn = document.getElementById('addSkillBtn');
    const skillTags = document.getElementById('skillTags');

    const previewName = document.getElementById('previewName');

    // Data store - pre-populate with existing skills
    const profile = {
      displayname: '{{ $gig->display_name }}',
      profileimg: null,
      description: '{{ $gig->description }}',
      skills: @json($gig->skills->map(function($skill) {
        return [
          'id' => (string)$skill->skillId,
          'name' => $skill->name,
          'level' => $skill->pivot->experienceLevel
        ];
      })),
      college: '{{ $gig->college }}',
      linkedin: '{{ $gig->linkedin }}',
      git: '{{ $gig->git }}'
    };

    // Helpers
    function setStep(step) {
      if (step === 1) {
        step1.classList.remove('hidden');
        step2.classList.add('hidden');
        progressEl.style.width = '25%';
        uiStepLabel.textContent = '1';
        dot1.classList.add('bg-white', 'text-slate-700');
        dot2.classList.add('bg-slate-50', 'text-slate-400');
      } else {
        step1.classList.add('hidden');
        step2.classList.remove('hidden');
        progressEl.style.width = '100%';
        uiStepLabel.textContent = '2';
        dot2.classList.add('bg-white', 'text-slate-700');
      }
    }

    setStep(1);

    // Description live count
    desc.addEventListener('input', () => {
      const len = desc.value.length;
      descCount.textContent = len;
      profile.description = desc.value;
      descMin.style.color = len < 150 ? '#ef4444' : '#10b981';
    });

    // Image upload
    uploadBtn.addEventListener('click', () => profileimg.click());
    profileimg.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;
      if (!file.type.startsWith('image/')) return alert('Please upload an image file.');
      if (file.size > 5 * 1024 * 1024) return alert('Image too large. Max 5MB.');

      profile.profileimg = file;
      const reader = new FileReader();
      reader.onload = function(ev) {
        const img = document.createElement('img');
        img.src = ev.target.result;
        img.className = "w-full h-full object-cover";
        avatarPreview.innerHTML = '';
        avatarPreview.appendChild(img);
      };
      reader.readAsDataURL(file);
    });

    // Preview name (only displayname now)
    document.getElementById('displayname').addEventListener('input', updatePreviewName);

    function updatePreviewName() {
      const dn = document.getElementById('displayname').value.trim();
      previewName.textContent = dn || '—';
      if (avatarInitial) {
        avatarInitial.textContent = dn ? dn[0].toUpperCase() : 'D';
      }
    }

    // Continue → Step 2
    toStep2Btn.addEventListener('click', () => {
      const dn = document.getElementById('displayname').value.trim();
      const bio = desc.value.trim();

      if (!dn) { alert('Please pick a display name.'); return; }
      if (bio.length < 150) { alert('Please write at least 150 characters for your bio.'); return; }

      profile.displayname = dn;
      setStep(2);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Back
    backTo1Btn.addEventListener('click', () => {
      setStep(1);
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Skill handling
    function renderSkills() {
      skillTags.innerHTML = '';
      profile.skills.forEach((s, idx) => {
        const pill = document.createElement('div');
        pill.className = 'tag px-3 py-1 rounded-full text-sm flex items-center gap-2';
        pill.innerHTML = `
          <span class="font-medium">${escapeHtml(s.name)}</span>
          <span class="text-xs px-2 py-0.5 rounded-md bg-white border border-slate-100 text-slate-500">${escapeHtml(s.level)}</span>
          <button data-idx="${idx}" class="ml-2 text-xs text-slate-400 hover:text-red-500 remove-skill">✕</button>`;
        skillTags.appendChild(pill);
      });

      document.querySelectorAll('.remove-skill').forEach(btn => {
        btn.addEventListener('click', (e) => {
          const i = Number(e.currentTarget.dataset.idx);
          profile.skills.splice(i,1);
          renderSkills();
        });
      });
    }

    // Render existing skills on load
    renderSkills();

    addSkillBtn.addEventListener('click', () => {
      const option = skillInput.selectedOptions[0];
      const id = option.value;
      const name = option.dataset.name;
      const level = skillExp.value;

      if (!id) return skillInput.focus();
      if (profile.skills.length >= 12) return alert('Max 12 skills allowed.');
      if (profile.skills.some(s => s.id === id)) return alert('Skill already added.');

      profile.skills.push({ id, name, level });
      skillInput.value = '';
      renderSkills();
    });

    skillInput.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') { e.preventDefault(); addSkillBtn.click(); }
    });

    document.getElementById('profileForm').addEventListener('submit', (e) => {
    // Validate skills
    if (profile.skills.length === 0) {
        e.preventDefault();
        alert('Please add at least one skill.');
        setStep(2);
        return;
    }

    // Pack skills into a hidden field so Laravel can receive them
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = 'skills';
    hidden.value = JSON.stringify(profile.skills);
    e.target.appendChild(hidden);
    });

    function escapeHtml(text) {
      const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"':'&quot;', "'": '&#039;' };
      return String(text).replace(/[&<>"']/g, m => map[m]);
    }
  </script>

</body>
</html>
