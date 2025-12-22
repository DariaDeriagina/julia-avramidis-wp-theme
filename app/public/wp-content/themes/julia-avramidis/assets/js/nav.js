/**
 * Mobile navigation (Julia Avramidis)
 *
 * Features:
 * - toggles .is-nav-open on #site-header
 * - syncs aria-expanded
 * - closes on ESC
 * - closes after clicking a menu link
 * - closes on scroll (mobile UX)
 * - updates CSS var --header-h for anchor scroll offset
 */
(function () {
	// ---------------------------------------------------------
	// 0) Grab elements
	// ---------------------------------------------------------
	const header = document.getElementById("site-header");
	if (!header) return;

	const btn = header.querySelector(".nav-toggle");
	const nav = header.querySelector("#site-nav");
	if (!btn || !nav) return;

	// ---------------------------------------------------------
	// 1) Helpers
	// ---------------------------------------------------------
	const isOpen = () => header.classList.contains("is-nav-open");

	const setState = (open) => {
		header.classList.toggle("is-nav-open", open);
		btn.setAttribute("aria-expanded", open ? "true" : "false");
	};

	const closeNav = () => setState(false);

	// ---------------------------------------------------------
	// 2) Toggle on button click
	// ---------------------------------------------------------
	btn.addEventListener("click", () => setState(!isOpen()));

	// ---------------------------------------------------------
	// 3) Close on ESC
	// ---------------------------------------------------------
	document.addEventListener("keydown", (e) => {
		if (e.key === "Escape") closeNav();
	});

	// ---------------------------------------------------------
	// 4) Close after clicking a link inside the nav
	// ---------------------------------------------------------
	nav.addEventListener("click", (e) => {
		const link = e.target.closest("a");
		if (link) closeNav();
	});

	// ---------------------------------------------------------
	// 5) Close on scroll (ONLY if menu is open)
	// ---------------------------------------------------------
	let scrollTicking = false;

	const onScroll = () => {
		if (!isOpen()) return;

		// throttle via rAF to avoid spamming
		if (scrollTicking) return;
		scrollTicking = true;

		requestAnimationFrame(() => {
			closeNav();
			scrollTicking = false;
		});
	};

	window.addEventListener("scroll", onScroll, { passive: true });

	// (Optional) also close on touch move (some mobile browsers feel smoother)
	window.addEventListener("touchmove", onScroll, { passive: true });

	// ---------------------------------------------------------
	// 6) Update CSS var --header-h (for anchor scroll padding)
	// ---------------------------------------------------------
	const updateHeaderHeightVar = () => {
		const h = header.offsetHeight || 80;
		document.documentElement.style.setProperty("--header-h", `${h}px`);
	};

	updateHeaderHeightVar();
	window.addEventListener("resize", updateHeaderHeightVar);
})();
