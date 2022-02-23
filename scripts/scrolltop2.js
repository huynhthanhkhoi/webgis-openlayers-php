// fixed menu
function fixedMenu() {
    if($('#main').length) {
        var windowScrollTop = $(window).scrollTop();
        var heightHeader =  0;
        if($(window).width() <= 991) heightHeader = 1;
        if(windowScrollTop > heightHeader) $('#main').addClass('fixedMenu');
        else $('#main').removeClass('fixedMenu');
    }
}
// end fixed menu

// Srcoll top
function showBtnScrollTop() {
    if($('.btnScrollTop').length) {
        var windowScrollTop = $(window).scrollTop();
        if(windowScrollTop > 1) $('.btnScrollTop').addClass('showBtnScrollTop');
        else $('.btnScrollTop').removeClass('showBtnScrollTop');
    }
}

$(".btnScrollTop").on('click', function(e){
    $('body,html').animate({
        scrollTop: 0
    }, 1000);

    e.preventDefault();
});
// end Srcoll top

$(window).on('scroll', function() {
    fixedMenu();
    showBtnScrollTop();
});
