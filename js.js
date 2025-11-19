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
document.querySelectorAll('.menu').forEach(menu => {
    menu.addEventListener('click', e => {
        if (e.target.tagName === 'BUTTON') {
            menu.querySelectorAll('button').forEach(btn => btn.classList.remove('active'));
            e.target.classList.add('active');
        }
    });
});

const searchInput = document.getElementById('buttonSearch');

searchInput.addEventListener('input', function () {
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