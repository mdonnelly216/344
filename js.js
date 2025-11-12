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
