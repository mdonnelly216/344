function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}


let currentMech = null;         
let selectedWeapons = [];       
let slots = [];
let activeSlotIndex = 0;
const MAX_SLOTS = 10;

//update weapon slots with selected weapons
function renderSelectedWeapons() {
    if (!slots.length) return;
    slots.forEach((slot, idx) => {
        const w = selectedWeapons[idx];
        slot.textContent = w ? w.name : "";
    });
}

/*Show weapon slots based on mech.no_weapons */
function updateWeaponSlotsVisibility() {
    if (!slots.length) return;
    const max = currentMech ? currentMech.no_weapons : MAX_SLOTS;
    slots.forEach((slot, idx) => {
        slot.style.display = (idx < max) ? "flex" : "none";
    });

    //Trim selected weapons if they exceed limit
    if (selectedWeapons.length > max) {
        selectedWeapons = selectedWeapons.slice(0, max);
        renderSelectedWeapons();
    }
}


document.addEventListener("DOMContentLoaded", () => {

    //weapon buttons
    const allButtons = document.querySelectorAll(".menu button");

    allButtons.forEach(button => {
        button.addEventListener("click", () => {
            allButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");
        });
    });

    //seaching for a weapon
    const weaponSearchInput = document.getElementById('buttonSearch');
    if (weaponSearchInput) {
        weaponSearchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            allButtons.forEach(btn => {
                const text = btn.textContent.toLowerCase();
                btn.style.display = (!query || text.includes(query)) ? "" : "none";
            });
        });
    }

    //seaching for a mech
    const mechSearchInput = document.getElementById('mechSearch');
    const mechButtons = document.querySelectorAll('.mechMenu button');
    const mechDisplay = document.getElementById('mechDisplay');

    if (mechSearchInput) {
        mechSearchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            mechButtons.forEach(btn => {
                const text = btn.textContent.toLowerCase();
                btn.style.display = (!query || text.includes(query)) ? "" : "none";
            });
        });
    }

    mechButtons.forEach(button => {
        button.addEventListener('click', () => {
            const mechName = button.textContent.trim();
            const fileName = mechName.toLowerCase().replace(/\s+/g, '') + ".png";

            if (mechDisplay) {
                mechDisplay.src = "Images/" + fileName;
            }

            //mech info
            currentMech = {
                id: parseInt(button.dataset.mechId, 10),
                name: mechName,
                no_weapons: parseInt(button.dataset.noWeapons, 10) || MAX_SLOTS
            };

            selectedWeapons = [];
            activeSlotIndex = 0;
            if (slots[0]) {
                slots[0].classList.add("active");
            }
            renderSelectedWeapons();
            updateWeaponSlotsVisibility();
        });
    });

    //weapon slots
    const slotContainer = document.getElementById("weaponSlots") ||
                          document.querySelector(".weaponSlots");

    if (slotContainer) {
        slots = Array.from(slotContainer.querySelectorAll(".weaponSlot"));

        
        if (!slots.length) {
            for (let i = 0; i < MAX_SLOTS; i++) {
                const div = document.createElement("div");
                div.className = "weaponSlot";
                slotContainer.appendChild(div);
                slots.push(div);
            }
        }

        slots.forEach((slot, idx) => {
            slot.addEventListener("click", () => {
                activeSlotIndex = idx;
                slots.forEach(s => s.classList.remove("active"));
                slot.classList.add("active");
            });
        });

        //first slot selected by default
        if (slots[0]) {
            slots[0].classList.add("active");
        }

        updateWeaponSlotsVisibility();
    }

    
    /* loadout saving and loading   */
    
    const saveBtn       = document.getElementById("saveLoadoutBtn");
    const loadBtn       = document.getElementById("loadLoadoutBtn");
    const loadoutSelect = document.getElementById("loadoutSelect");
    const nameInput     = document.getElementById("loadoutName");

    //Save loadout
    if (saveBtn) {
        saveBtn.addEventListener("click", () => {
            if (!currentMech) {
                alert("Select a mech first.");
                return;
            }
            const name = nameInput ? nameInput.value.trim() : "";
            if (!name) {
                alert("Give your loadout a name.");
                return;
            }
            if (!selectedWeapons.length) {
                alert("Add at least one weapon.");
                return;
            }

            const params = new URLSearchParams();
            params.append("mech_id", currentMech.id);
            params.append("name", name);
            selectedWeapons.forEach(w => {
                params.append("weapons[]", w.id);
            });

            fetch("save_loadout.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: params.toString()
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert("Error saving loadout: " + (data.error || "unknown"));
                        return;
                    }
                    alert("Loadout saved!");

                    
                    if (loadoutSelect) {
                        const opt = document.createElement("option");
                        opt.value = data.loadout_id;
                        opt.textContent = name + " (" + currentMech.name + ")";
                        loadoutSelect.insertBefore(opt, loadoutSelect.options[1] || null);
                        loadoutSelect.value = data.loadout_id;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert("Save failed.");
                });
        });
    }

    //loading loadout
    if (loadBtn && loadoutSelect) {
        loadBtn.addEventListener("click", () => {
            const id = loadoutSelect.value;
            if (!id) {
                alert("Pick a loadout to load.");
                return;
            }

            fetch("get_loadout.php?loadout_id=" + encodeURIComponent(id))
                .then(res => res.json())
                .then(data => {
                    if (!data.success) {
                        alert("Error loading: " + (data.error || "unknown"));
                        return;
                    }

                    //get mech
                    const mech = data.mech;
                    currentMech = {
                        id: mech.mech_id,
                        name: mech.name,
                        no_weapons: mech.no_weapons
                    };

                    
                    const mechBtn = Array.from(mechButtons).find(
                        b => parseInt(b.dataset.mechId, 10) === mech.mech_id
                    );
                    if (mechBtn) {
                        mechBtn.click();
                    } else {
                        updateWeaponSlotsVisibility();
                    }

                    //get weapongs
                    selectedWeapons = data.weapons.map(w => ({
                        id: w.weapon_id,
                        name: w.name
                    }));

                    renderSelectedWeapons();
                    updateWeaponSlotsVisibility();
                })
                .catch(err => {
                    console.error(err);
                    alert("Load failed.");
                });
        });
    }
});

//adding weapons to loadout and slot
function addWeapon() {
    const activeWeaponButton = document.querySelector(".menu button.active");

    if (!activeWeaponButton) {
        alert("No weapon selected!");
        return;
    }

    if (!currentMech) {
        alert("Select a mech first!");
        return;
    }

    const max = currentMech.no_weapons || MAX_SLOTS;
    if (selectedWeapons.length >= max && !selectedWeapons[activeSlotIndex]) {
        alert("This mech can only mount " + max + " weapons.");
        return;
    }

    const weapon = {
        id: parseInt(activeWeaponButton.dataset.weaponId, 10),
        name: activeWeaponButton.textContent.trim()
    };

    let idx = activeSlotIndex;
    if (idx >= max) {
        idx = selectedWeapons.length;
    }
    selectedWeapons[idx] = weapon;

    // remove holes
    selectedWeapons = selectedWeapons.filter(Boolean);

    renderSelectedWeapons();
}
