const touriztoliteResponsiveMenu = (options = {}) => {

	const defaults = {
		wrapper: '.main-navigation',
		menu: '.menu',
		threshold: 640, // Minimal menu width,
		touriztoliteleMenuClass: 'touriztolitele-menu',
		touriztoliteleMenuOpenClass: 'touriztolitele-menu-open',
		touriztoliteleMenuToggleButtonClass: 'touriztolitele-menu-toggle-button',
		toggleButtonTemplate: '<i class="touriztolitele-menu-close fa fa-bars" aria-hidden="true"></i><i class="touriztolitele-menu-open fa fa-times" aria-hidden="true"></i>'
	}
	options = Object.assign(defaults, options);

	const wrapper = options.wrapper.nodeType ?
		options.wrapper :
		document.querySelector(options.wrapper);

	const menu = options.menu.nodeType ?
		options.menu :
		document.querySelector(options.menu);

	let toggleButton,
		toggleButtonOpenBlock,
		toggleButtonCloseBlock,
		isTouriztoliteleMenu,
		isTouriztoliteleMenuOpen;

	// series

	const init = [
		addToggleButton,
		checkScreenWidth,
		addResizeHandler
	]

	if (wrapper && menu) {
		runSeries(init);
	}

	function addToggleButton() {
		toggleButton = document.createElement('button');

		toggleButton.innerHTML = options.toggleButtonTemplate.trim();
		toggleButton.className = options.touriztoliteleMenuToggleButtonClass;
		wrapper.insertBefore(toggleButton, wrapper.children[0]);

		toggleButtonOpenBlock = toggleButton.querySelector('.touriztolitele-menu-open');
		toggleButtonCloseBlock = toggleButton.querySelector('.touriztolitele-menu-close');

		toggleButton.addEventListener('click', touriztoliteleMenuToggle);
	}

	// menu switchers

	function switchToTouriztoliteleMenu() {
		wrapper.classList.add(options.touriztoliteleMenuClass);
		toggleButton.style.display = "block";
		isTouriztoliteleMenuOpen = false;
		hideMenu();
	}

	function switchToDesktopMenu() {
		wrapper.classList.remove(options.touriztoliteleMenuClass);
		toggleButton.style.display = "none";
		showMenu();
	}

	// touriztolitele menu toggle

	function touriztoliteleMenuToggle() {
		if (isTouriztoliteleMenuOpen) {
			hideMenu();
		} else {
			showMenu();
		}
		isTouriztoliteleMenuOpen = !isTouriztoliteleMenuOpen;
	}

	function hideMenu() {
		wrapper.classList.remove(options.touriztoliteleMenuOpenClass);
		menu.style.display = "none";
		toggleButtonOpenBlock.style.display = "none";
		toggleButtonCloseBlock.style.display = "block";
	}

	function showMenu() {
		wrapper.classList.add(options.touriztoliteleMenuOpenClass);
		menu.style.display = "block";
		toggleButtonOpenBlock.style.display = "block";
		toggleButtonCloseBlock.style.display = "none";
	}

	// resize helpers

	function checkScreenWidth() {
		let currentTouriztoliteleMenuStatus = window.innerWidth < options.threshold ? true : false;

		if (isTouriztoliteleMenu !== currentTouriztoliteleMenuStatus) {
			isTouriztoliteleMenu = currentTouriztoliteleMenuStatus;
			isTouriztoliteleMenu ? switchToTouriztoliteleMenu() : switchToDesktopMenu();
		}
	}

	function addResizeHandler() {
		window.addEventListener('resize', resizeHandler);
	}

	function resizeHandler() {
		window.requestAnimationFrame(checkScreenWidth)
	}

	// general helpers

	function runSeries(functions) {
		functions.forEach(func => func());
	}
}