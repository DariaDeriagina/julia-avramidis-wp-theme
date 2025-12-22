/* =========================
   Sticky header helper
   ========================= */

(function () {
	const header = document.querySelector(".site-header");
	if (!header) return;

	// Set CSS variable --header-h to the actual header height
	const setHeaderHeight = () => {
		document.documentElement.style.setProperty(
			"--header-h",
			`${header.offsetHeight}px`
		);
	};

	// Initial set + keep updated on resize
	setHeaderHeight();
	window.addEventListener("resize", setHeaderHeight);
})();
