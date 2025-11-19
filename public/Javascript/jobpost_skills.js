// Convert skill objects to an array of skill names
const ALL_SKILLS = window.ALL_SKILLS.map(skill => skill.name);

// DOM elements
const selectedContainer = document.getElementById('selected-skills-container');
const suggestedContainer = document.getElementById('suggested-skills-container');
const dataInput = document.getElementById('selectedskillsdata');
const searchInput = document.getElementById('skills-search');

let selectedSkills = [];
let filteredSkills = [...ALL_SKILLS];

// RENDER SKILL TAG
function renderSkillTag(skillName, isSelected) {
    const iconSvg = isSelected
        ? '<svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'
        : '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>';

    const baseClasses =
        "inline-flex items-center text-sm font-medium px-3 py-1 rounded-full transition duration-150 cursor-pointer";

    if (isSelected) {
        return `
            <span data-skill="${skillName}" class="${baseClasses} bg-gray-200 text-gray-800 border border-gray-300" onclick="removeSkill('${skillName}')">
                ${skillName}
                <button type="button" class="ml-2 text-gray-500">${iconSvg}</button>
            </span>
        `;
    }

    // Suggested only if not selected
    if (!selectedSkills.includes(skillName)) {
        return `
            <span data-skill="${skillName}" class="${baseClasses} bg-gray-100 text-gray-700 border border-gray-300 hover:bg-gray-200" onclick="addSkill('${skillName}')">
                ${skillName}
                <span class="ml-1.5 text-gray-500">${iconSvg}</span>
            </span>
        `;
    }

    return "";
}

// UPDATE THE UI
function updateUI() {
    selectedContainer.innerHTML = selectedSkills
        .map(skill => renderSkillTag(skill, true))
        .join("");

    suggestedContainer.innerHTML = filteredSkills
        .map(skill => renderSkillTag(skill, false))
        .join("");

    dataInput.value = selectedSkills.join(",");
}

// ADD SKILL
window.addSkill = function(skillName) {
    if (!selectedSkills.includes(skillName)) {
        selectedSkills.push(skillName);
        searchInput.value = "";
        filteredSkills = [...ALL_SKILLS];
        updateUI();
    }
};

// REMOVE SKILL
window.removeSkill = function(skillName) {
    selectedSkills = selectedSkills.filter(skill => skill !== skillName);
    updateUI();
};

// SEARCH FILTER
searchInput.addEventListener("input", (e) => {
    const query = e.target.value.toLowerCase();

    filteredSkills = query
        ? ALL_SKILLS.filter(skill => skill.toLowerCase().includes(query))
        : [...ALL_SKILLS];

    updateUI();
});

// ADD CUSTOM SKILL WITH ENTER
searchInput.addEventListener("keyup", (e) => {
    if (e.key === "Enter" && searchInput.value.trim() !== "") {
        const newSkill = searchInput.value.trim();

        if (!ALL_SKILLS.includes(newSkill)) {
            ALL_SKILLS.push(newSkill);
        }
        addSkill(newSkill);
    }
});

// INITIAL RENDER
updateUI();
