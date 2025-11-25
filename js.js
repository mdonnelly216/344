/* -------------------- */
/* SIDENAV FUNCTIONALITY */
/* -------------------- */
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
    document.querySelectorAll(".menu").forEach(menu => {
        menu.addEventListener("click", e => {
            if (e.target.tagName === "BUTTON") {
                menu.querySelectorAll("button").forEach(btn => btn.classList.remove("active"));
                e.target.classList.add("active");
            }
        });
    });
});

// Make only one button active per menu
const allButtons = document.querySelectorAll(".menu button");

    allButtons.forEach(button => {
        button.addEventListener("click", () => {
            // Remove active from ALL buttons in ALL menus
            allButtons.forEach(btn => btn.classList.remove("active"));

            // Activate the clicked one
            button.classList.add("active");
        });
    });


const weaponSearchInput = document.getElementById('buttonSearch');

weaponSearchInput.addEventListener('input', function () {
    const query = this.value.trim().toLowerCase();

    document.querySelectorAll('.menu button').forEach(btn => {
        const text = btn.textContent.toLowerCase();
        if (!query || text.includes(query)) {
            btn.style.display = '';
        } else {
            btn.style.display = 'none';
        }
    });
});


const mechSearchInput = document.getElementById('mechSearch');

mechSearchInput.addEventListener('input', function () {
    const query = this.value.trim().toLowerCase();

    document.querySelectorAll('.mechMenu button').forEach(btn => {
        const text = btn.textContent.toLowerCase();
        if (!query || text.includes(query)) {
            btn.style.display = '';
        } else {
            btn.style.display = 'none';
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const mechButtons = document.querySelectorAll('.mechMenu button');
    const mechDisplay = document.getElementById('mechDisplay');

    mechButtons.forEach(button => {
        button.addEventListener('click', () => {
            const mechName = button.textContent.trim();
            const fileName = mechName.toLowerCase().replace(/\s+/g, '') + ".png";
            mechDisplay.src = "Images/" + fileName;
        });
    });
});

document.querySelectorAll(".weaponSlot").addEventListener("click", () => {
    alert("Div clicked!");
const slots = document.querySelectorAll(".weaponSlot");

slots.forEach(slot => {
    slot.addEventListener("click", () => {
        slots.forEach(s => s.classList.remove("active")); // clear all
        slot.classList.add("active");                      // set clicked

    });
});



weapons = [];
weapons.length = 
function addWeapon(){
    const activeWeaponButton = document.querySelector(".menu button.active");
    weapons += activeWeaponButton.textContent;

}

