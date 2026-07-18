/**
 * AeroWind Energy — front-end interactions.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var header = document.getElementById('aw-header');
		var burger = document.getElementById('aw-burger');

		if (burger && header) {
			burger.addEventListener('click', function () {
				header.classList.toggle('aw-open');
			});
			// Close menu when a nav link is clicked (mobile).
			header.querySelectorAll('.aw-nav a').forEach(function (link) {
				link.addEventListener('click', function () {
					header.classList.remove('aw-open');
				});
			});
		}
	});
})();
