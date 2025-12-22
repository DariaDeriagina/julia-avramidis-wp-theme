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
// Testimonials slider (mobile: dots, desktop: prev/next + 2-up)
document.addEventListener("DOMContentLoaded", () => {
	const root = document.querySelector("[data-testimonials]");
	if (!root) return;

	const track = root.querySelector(".testimonials__track");
	const items = Array.from(root.querySelectorAll("[data-testimonial]"));
	const dots = Array.from(root.querySelectorAll("[data-dot]"));
	const btnPrev = root.querySelector("[data-prev]");
	const btnNext = root.querySelector("[data-next]");

	if (!track || items.length === 0) return;

	let index = 0;

	const isDesktop = () => window.matchMedia("(min-width: 901px)").matches;
	const visibleCount = () => (isDesktop() ? 2 : 1);
	const maxIndex = () => Math.max(0, items.length - visibleCount());

	const getGap = () => {
		const cs = getComputedStyle(track);
		const g = parseFloat(cs.columnGap || cs.gap || "0") || 0;
		return g;
	};

	const getStep = () => {
		const gap = getGap();
		const w = items[0].getBoundingClientRect().width;
		return w + gap;
	};

	const setActiveDot = (i) => {
		dots.forEach((d, idx) => d.classList.toggle("is-active", idx === i));
	};

	const update = () => {
		index = Math.min(Math.max(index, 0), maxIndex());
		const step = getStep();
		track.style.transform = `translateX(${-index * step}px)`;

		if (!isDesktop()) setActiveDot(index);

		if (btnPrev) btnPrev.disabled = index === 0;
		if (btnNext) btnNext.disabled = index === maxIndex();
	};

	// dots (mobile)
	dots.forEach((d) => {
		d.addEventListener("click", () => {
			index = parseInt(d.dataset.dot, 10) || 0;
			update();
		});
	});

	// prev/next (desktop)
	btnPrev?.addEventListener("click", () => {
		index -= 1;
		update();
	});
	btnNext?.addEventListener("click", () => {
		index += 1;
		update();
	});

	window.addEventListener("resize", update);

	// init
	setActiveDot(0);
	update();
});
