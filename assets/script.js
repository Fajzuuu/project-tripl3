console.log("Website loaded successfully");

function toggleUserMenu() {
    const menu = document.getElementById("userDropdown");
    if (!menu) return;

    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

document.addEventListener("click", function (e) {
    const userMenu = document.querySelector(".user-menu");
    const dropdown = document.getElementById("userDropdown");

    if (!userMenu || !dropdown) return;

    if (!userMenu.contains(e.target)) {
        dropdown.style.display = "none";
    }
});
