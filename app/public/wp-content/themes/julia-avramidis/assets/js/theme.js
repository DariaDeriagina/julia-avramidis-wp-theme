/* =========================================================
   Theme JS
   - Mobile nav toggle (hamburger)
   - Sticky header height -> CSS var (--header-h)
   ========================================================= */

document.addEventListener("DOMContentLoaded", () => {
	const header = document.getElementById("site-header");
	const toggle = document.querySelector(".nav-toggle");
	const nav = document.getElementById("site-nav");

	if (!header) return;

	// ---------------------------------------------------------
	// 1) Keep CSS scroll offset correct (anchors / sticky header)
	// ---------------------------------------------------------
	const setHeaderHeightVar = () => {
		const h = header.offsetHeight || 80;
		document.documentElement.style.setProperty("--header-h", `${h}px`);
	};

	setHeaderHeightVar();
	window.addEventListener("resize", setHeaderHeightVar);

	// ---------------------------------------------------------
	// 2) Mobile menu toggle
	// ---------------------------------------------------------
	if (!toggle || !nav) return;

	const closeMenu = () => {
		header.classList.remove("is-nav-open");
		toggle.setAttribute("aria-expanded", "false");
	};

	const openMenu = () => {
		header.classList.add("is-nav-open");
		toggle.setAttribute("aria-expanded", "true");
	};

	toggle.addEventListener("click", () => {
		const isOpen = header.classList.contains("is-nav-open");
		isOpen ? closeMenu() : openMenu();
	});

	// Close on ESC (accessibility)
	document.addEventListener("keydown", (e) => {
		if (e.key === "Escape") closeMenu();
	});

	// Close when clicking outside header
	document.addEventListener("click", (e) => {
		if (!header.contains(e.target)) closeMenu();
	});

	// Close when switching back to desktop width
	window.addEventListener("resize", () => {
		if (window.innerWidth > 900) closeMenu();
	});
});
