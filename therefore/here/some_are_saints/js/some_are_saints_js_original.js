var myScroll;
var myScroll2;
function loaded () {
    myScroll = new IScroll('.content', {
        scrollX: false,
        scrollY: true,
        mouseWheel: true,
        scrollbars: true,
        // fadeScrollbars: true,
        interactiveScrollbars: true,
        deceleration: 0.005,
        bounce: false,
        keyBindings: true,
        scrollbars: 'custom',
        resizeScrollbars: false
    });
    myScroll2 = new IScroll('.beckett-text', {
        scrollX: false,
        scrollY: true,
        mouseWheel: true,
        scrollbars: true,
        fadeScrollbars: false,
        interactiveScrollbars: true,
        deceleration: 0.005,
        bounce: false,
        keyBindings: true,
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

$(function() {
    $(document).ready(function() {
        $('.circle').after('<div class="circle__outside"><div class="circle__outside__inside"></div></div>');
    });
});
