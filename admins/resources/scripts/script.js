(function () {
	'use strict';

	function slideToggle(el, duration) {
		duration = duration || 200;
		if (!el) return;
		var computed = window.getComputedStyle(el);
		if (computed.display === 'none') el.style.display = 'block';

		if (el.style.maxHeight && el.style.maxHeight !== '0px') {
			el.style.transition = 'max-height ' + duration + 'ms ease';
			el.style.maxHeight = '0px';
			el.setAttribute('data-collapsed', 'true');
			return;
		}

		el.style.overflow = 'hidden';
		el.style.maxHeight = '0px';
		// force reflow
		/* eslint-disable no-unused-expressions */
		el.offsetHeight;
		/* eslint-enable no-unused-expressions */
		el.style.transition = 'max-height ' + duration + 'ms ease';
		el.style.maxHeight = el.scrollHeight + 'px';
		el.setAttribute('data-collapsed', 'false');
		setTimeout(function () {
			if (el.getAttribute('data-collapsed') === 'false') {
				el.style.maxHeight = 'none';
			}
		}, duration + 20);
	}

	function findChildUl(button) {
		// Common structures:
		// <a class="nav-top-item">..</a><ul>..</ul>
		// <li><a class="nav-top-item">..</a><ul>..</ul></li>
		var el = button.nextElementSibling;
		if (el && el.tagName && el.tagName.toLowerCase() === 'ul') return el;

		var parent = button.parentElement;
		if (parent) {
			for (var i = 0; i < parent.children.length; i++) {
				var ch = parent.children[i];
				if (ch.tagName && ch.tagName.toLowerCase() === 'ul') return ch;
			}
		}

		// fallback: query inside button
		el = button.querySelector('ul');
		return el;
	}

	function initNavToggles() {
		var toggles = document.querySelectorAll('.nav-top-item');
		if (!toggles || toggles.length === 0) return;

		toggles.forEach(function (btn) {
			var ul = findChildUl(btn);
			if (!ul) return;

			// make element keyboard accessible
			if (!btn.hasAttribute('tabindex')) btn.setAttribute('tabindex', '0');
			btn.setAttribute('role', 'button');
			btn.setAttribute('aria-expanded', 'false');

			// ensure collapsed initial state
			ul.style.overflow = 'hidden';
			ul.style.maxHeight = '0px';
			ul.setAttribute('data-collapsed', 'true');

			btn.addEventListener('click', function (e) {
				e.preventDefault();
				var expanded = btn.getAttribute('aria-expanded') === 'true';
				btn.setAttribute('aria-expanded', (!expanded).toString());
				btn.classList.toggle('open', !expanded);
				slideToggle(ul, 200);
			});

			btn.addEventListener('keydown', function (e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					btn.click();
				}
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initNavToggles);
	} else {
		initNavToggles();
	}
})();

