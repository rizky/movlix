function hideNextSiblings(el) {
	i = 0;
    while (el= el.nextElementSibling) {
		el.className = '';
		if (i == 0)
			el.classList.add('next');
		else if (i == 1)
			el.classList.add('nextRightSecond');
		else
			el.classList.add('hideRight');
		i++;
	}
}
function hidePrevSiblings(el) {
	i = 0;
    while (el= el.previousElementSibling) {
		el.className = '';
		if (i == 0)
			el.classList.add('prev');
		else if (i == 1)
			el.classList.add('prevLeftSecond');
		else
			el.classList.add('hideLeft');
		i++;
	}
}

function moveToSelected(element) {
	if (element == "next") {
		var selected = document.querySelectorAll(".selected").nextElementSibling;
	} else if (element == "prev") {
		var selected = document.querySelectorAll(".selected").previousElementSibling;
	} else {
		var selected = element;
	}
	selected.className = '';
	selected.classList.add('selected');
	hideNextSiblings(selected);
	hidePrevSiblings(selected);
}
