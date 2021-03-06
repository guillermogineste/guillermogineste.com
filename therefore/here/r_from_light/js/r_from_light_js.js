var myScroll;
function loaded () {
    myScroll = new IScroll('.content', {
        scrollX: true,
        scrollY: false,
        mouseWheel: true,
        scrollbars: true,
        fadeScrollbars: false,
        interactiveScrollbars: true,
        deceleration: 0.005,
        bounce: false,
        keyBindings: true,
        scrollbars: 'custom',
        resizeScrollbars: false,
    });
    myScroll.on('scrollStart', function(){
		$('.drag-to-move').fadeOut(); //hide the button
	});
}

if(window.attachEvent) {
    window.attachEvent('onload', loaded());
} else {
    if(window.onload) {
        var curronload = window.onload;
        var newonload = function(evt) {
            curronload(evt);
            loaded();
        };
        window.onload = newonload;
    } else {
        window.onload = function() {
            loaded();
        };
    }
}

document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
