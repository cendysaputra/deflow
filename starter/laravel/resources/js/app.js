/* App */
(() => {
	/* Tabs */
	const initTabs = (root) => {
		const list = root.querySelector('[role="tablist"]');
		const tabs = [...root.querySelectorAll('[role="tab"]')];
		if (!list || !tabs.length) return;

		const panels = tabs.map((tab) => document.getElementById(tab.getAttribute('aria-controls')));

		const select = (index, focus = false) => {
			tabs.forEach((tab, i) => {
				const active = i === index;
				tab.setAttribute('aria-selected', String(active));
				tab.tabIndex = active ? 0 : -1;
				tab.classList.toggle('is-active', active);
				if (panels[i]) panels[i].hidden = !active;
			});
			if (focus) tabs[index].focus();
		};

		list.addEventListener('click', (event) => {
			const tab = event.target.closest('[role="tab"]');
			if (tab) select(tabs.indexOf(tab));
		});

		list.addEventListener('keydown', (event) => {
			const current = tabs.indexOf(document.activeElement);
			if (current < 0) return;

			const last = tabs.length - 1;
			const target = {
				ArrowRight: current === last ? 0 : current + 1,
				ArrowLeft: current === 0 ? last : current - 1,
				Home: 0,
				End: last,
			}[event.key];

			if (target === undefined) return;
			event.preventDefault();
			select(target, true);
		});

		const initial = tabs.findIndex((tab) => tab.getAttribute('aria-selected') === 'true');
		list.hidden = false;
		select(Math.max(0, initial));
	};

	/* Init */
	const init = (selector, fn) => document.querySelectorAll(selector).forEach(fn);

	init('[data-tabs]', initTabs);
})();
