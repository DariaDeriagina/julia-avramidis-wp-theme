// /assets/js/testimonials.js
document.addEventListener("DOMContentLoaded", () => {
	const roots = document.querySelectorAll("[data-testimonials]");
	if (!roots.length) return;

	roots.forEach((root) => {
		const viewport = root.querySelector(".testimonials__viewport");
		const track = root.querySelector(".testimonials__track");
		const items = Array.from(root.querySelectorAll("[data-testimonial]"));
		const dots = Array.from(root.querySelectorAll("[data-dot]"));
		const btnPrev = root.querySelector("[data-prev]");
		const btnNext = root.querySelector("[data-next]");

		if (!viewport || !track || items.length === 0) return;

		let index = 0;

		const isDesktop = () => window.matchMedia("(min-width: 901px)").matches;
		const visibleCount = () => (isDesktop() ? 2 : 1);
		const maxIndex = () => Math.max(0, items.length - visibleCount());

		const getGap = () => {
			const cs = getComputedStyle(track);
			const g = cs.gap || cs.columnGap || "0";
			// "28px" or "28px 28px" -> 28
			return parseFloat(String(g).split(" ")[0]) || 0;
		};

		const getStep = () => {
			const gap = getGap();
			const w = items[0].getBoundingClientRect().width;
			return w + gap;
		};

		const setActiveDot = (i) => {
			dots.forEach((d, idx) => d.classList.toggle("is-active", idx === i));
		};

		const setTranslate = (px, withAnim = true) => {
			track.style.transition = withAnim ? "transform 420ms ease" : "none";
			track.style.transform = `translate3d(${px}px, 0, 0)`;
		};

		const update = () => {
			index = Math.min(Math.max(index, 0), maxIndex());

			const step = getStep();
			setTranslate(-index * step, true);

			// Dots only relevant on mobile
			if (!isDesktop() && dots.length) setActiveDot(index);

			if (btnPrev) btnPrev.disabled = index === 0;
			if (btnNext) btnNext.disabled = index === maxIndex();
		};

		// Dots (mobile)
		dots.forEach((d) => {
			d.addEventListener("click", () => {
				index = parseInt(d.dataset.dot, 10) || 0;
				update();
			});
		});

		// Prev/Next (desktop)
		btnPrev?.addEventListener("click", () => {
			index -= 1;
			update();
		});
		btnNext?.addEventListener("click", () => {
			index += 1;
			update();
		});

		// --- Swipe / drag (mobile + touch devices) ---
		let pointerDown = false;
		let startX = 0;
		let startY = 0;
		let baseX = 0;

		const getCurrentTranslateX = () => {
			const m = new DOMMatrixReadOnly(getComputedStyle(track).transform);
			return m.m41 || 0;
		};

		const onPointerDown = (e) => {
			if (isDesktop()) return; // swipe only on mobile
			pointerDown = true;
			startX = e.clientX;
			startY = e.clientY;
			baseX = getCurrentTranslateX();
			viewport.setPointerCapture?.(e.pointerId);
			setTranslate(baseX, false);
		};

		const onPointerMove = (e) => {
			if (!pointerDown) return;

			const dx = e.clientX - startX;
			const dy = e.clientY - startY;

			// If user is scrolling vertically, don't hijack
			if (Math.abs(dy) > Math.abs(dx) && Math.abs(dy) > 8) return;

			e.preventDefault();
			setTranslate(baseX + dx, false);
		};

		const onPointerUp = (e) => {
			if (!pointerDown) return;
			pointerDown = false;

			const dx = e.clientX - startX;
			const step = getStep();
			const threshold = step * 0.2; // swipe distance required

			if (dx < -threshold) index += 1;
			if (dx > threshold) index -= 1;

			update();
		};

		// Pointer events cover touch + mouse on modern browsers
		viewport.addEventListener("pointerdown", onPointerDown, { passive: true });
		viewport.addEventListener("pointermove", onPointerMove, { passive: false });
		viewport.addEventListener("pointerup", onPointerUp, { passive: true });
		viewport.addEventListener("pointercancel", onPointerUp, { passive: true });

		// Resize / orientation flip
		window.addEventListener("resize", update);

		// init
		if (dots.length) setActiveDot(0);
		update();
	});
});
