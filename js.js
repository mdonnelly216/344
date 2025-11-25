function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

/* -------------------- */
/* MENU SELECTION LOGIC */
/* -------------------- */
document.addEventListener("DOMContentLoaded", () => {

    // Make only one weapon active across ALL menus
    const allButtons = document.querySelectorAll(".menu button");

    allButtons.forEach(button => {
        button.addEventListener("click", () => {
            allButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");
        });
    });

    /* -------------------- */
    /* WEAPON SEARCH         */
    /* -------------------- */
    const weaponSearchInput = document.getElementById('buttonSearch');

    weaponSearchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();

        allButtons.forEach(btn => {
            const text = btn.textContent.toLowerCase();
            btn.style.display = (!query || text.includes(query)) ? "" : "none";
        });
    });

    /* -------------------- */
    /* MECH SEARCH & DISPLAY */
    /* -------------------- */
    const mechSearchInput = document.getElementById('mechSearch');
    const mechButtons = document.querySelectorAll('.mechMenu button');
    const mechDisplay = document.getElementById('mechDisplay');

    mechSearchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();

        mechButtons.forEach(btn => {
            const text = btn.textContent.toLowerCase();
            btn.style.display = (!query || text.includes(query)) ? "" : "none";
        });
    });

    mechButtons.forEach(button => {
        button.addEventListener('click', () => {
            const mechName = button.textContent.trim();
            const fileName = mechName.toLowerCase().replace(/\s+/g, '') + ".png";
            mechDisplay.src = "Images/" + fileName;
        });
    });

    /* -------------------- */
    /* WEAPON SLOT SELECTION */
    /* -------------------- */
    const slots = document.querySelectorAll(".weaponSlot");

    slots.forEach(slot => {
        slot.addEventListener("click", () => {
            slots.forEach(s => s.classList.remove("active"));
            slot.classList.add("active");
        });
    });

});

/* -------------------- */
/* ADD WEAPON FUNCTION  */
/* -------------------- */
let weapons = [];

function addWeapon() {
    const activeWeaponButton = document.querySelector(".menu button.active");

    if (!activeWeaponButton) {
        alert("No weapon selected!");
        return;
    }

    weapons.push(activeWeaponButton.textContent);
    console.log("Current weapons:", weapons);
}
