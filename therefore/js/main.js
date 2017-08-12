// Classes
// submenu-is-closed 	-- top class, if all submenus are closed
// is-collapsed         -- collapses the menu or aside

(function() {
	//set current menu if there is one open
	var currentMenuItem = $(".primary-navigation > .menu-item.active");
	//set current submenu if there is one open
	var currentSubMenuItem = $(".secondary-navigation > .menu-item.active");
	var navigation = $(".navigation");
	var aside = $(".aside");
	var body = $("body");

	function handleMenuItemClick() {
		if (currentMenuItem) {
			currentMenuItem.removeClass("active");
			// if the last selected menu is the same as the current selected one,
			// it will hide the submenu bg and ends the function,
			// so it not selects again
			// it only applies to itens with children
			if (currentMenuItem.is($(this).parent()) && currentMenuItem.hasClass('menu-item--has-children')) {
				toggleSubmenuBg();
				currentMenuItem = null;
				return;
			}
		}

		currentMenuItem = $(this).parent();
		currentMenuItem.addClass("active");
		toggleSubmenuBg();
	}

	function handleSubMenuItemClick() {
		if (currentSubMenuItem) {
			currentSubMenuItem.removeClass("active");
		}

		currentSubMenuItem = $(this).parent();
		currentSubMenuItem.addClass("active");
	}

	function toggleSubmenuBg() {
		if (currentMenuItem.hasClass('menu-item--has-children') && currentMenuItem.hasClass('active')) {
			navigation.removeClass("submenu-is-closed");
		} else {
			navigation.addClass("submenu-is-closed");
		}
	}

	// NAVIGATION
	function collapseNavigation() {
		navigation.toggleClass('is-collapsed');
		// if window is bigger than 800 collapse or open also aside
		if (parseInt($(window).width()) > 800) {
			collapseAside();
		}
		if (navigation.hasClass('is-collapsed')) {
			$(".navigation--collapse").fadeIn(100);
		} else {
			$(".navigation--collapse").fadeOut(100);
		}
	}
	// ASIDE
	function collapseAside() {
		if (aside.hasClass('is-collapsed')) {
			aside.toggleClass('is-collapsed');
			if (aside.hasClass('is-collapsed')) {
				$(".aside--collapse").fadeIn(100);
			} else {
				$(".aside--collapse").fadeOut(100);
			}
		}
	}
	// NAVIGATION + ASIDE
	function collapseAll() {
		navigation.addClass('is-collapsed');
		aside.addClass('is-collapsed');

		if (navigation.hasClass('is-collapsed')) {
			$(".navigation--collapse").fadeIn(100);
		} else {
			$(".navigation--collapse").fadeOut(100);
		}

		if (aside.hasClass('is-collapsed')) {
			$(".aside--collapse").fadeIn(100);
		} else {
			$(".aside--collapse").fadeOut(100);
		}
	}
	// OVERLAY
	function hideOverlay() {
		if ($('.overlay').is(":hidden")){
			$('.overlay').fadeIn(100);
			body.addClass("overlay-is-open");
		} else if($('.overlay').is(":visible") &&
		navigation.hasClass("is-collapsed") &&
		aside.hasClass("is-collapsed"))  {
			$('.overlay').fadeOut(100);
			body.removeClass("overlay-is-open");
		}
	}


	$(document).ready(function() {
		$('.primary-navigation > .menu-item > *:first-child').click(handleMenuItemClick);
		$('.secondary-navigation > .menu-item > *:first-child').click(handleSubMenuItemClick);

		$('.navigation--collapse')
		.bind('click', collapseNavigation)
		.bind('click', hideOverlay);
		// click on aside collapse button collapses only asside
		$('.aside--collapse')
		.bind('click', collapseAside)
		.bind('click', hideOverlay);
		// click on overlay collapses menu && navigation + hides overlay
		$('.overlay')
		.bind('click', collapseAll)
		.bind('click', hideOverlay);
		// click on link collapses menu && navigation + hides overlay
		$('.menu-item > a')
		.bind('click', collapseAll)
		.bind('click', hideOverlay);
	});
	// Hide drag to move
	$(document).mousedown(function(){
		$('.drag-to-move').fadeOut(); //hide the button
	});
	// Loader
	$(window).load(function() {
		$(".status").fadeOut(100); // will first fade out the loading animation
		$(".preloader").delay(350).fadeOut("slow"); // will fade out the white DIV that covers the website.
	});
})();
