$(window).scroll(function () {
    if ($(window).scrollTop() > 50) {
        $("#nav").css({backgroundColor: "#fff"});
        $("#nav a").css({color: "#999"});
    } else {
        $("#nav").css({backgroundColor: "transparent"});
        $("#nav a ").css({color: "#d8d8d8"});
    }
});
//////////////////////////////////////////////////////////////////////////////////////////
$("#header-index #nav #burger").click(function () {
    $(this).toggleClass("open");
    $('body').toggleClass("open-nav");
});
//////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function () {
    $(".movieh").hover3d({
        selector: ".movieh__card",
        perspective: 10000,
        sensitivity: 150
    });
});
//////////////////////////////////////////////////////////////////////////////////////////
var width = $(window).width() / 1.8;
$("#banner-big-bg .movieh .movieh__card").css({height: width});
$(window).resize(function () {
    var width = $(window).width() / 1.8;
    $("#banner-big-bg .movieh .movieh__card").css({height: width});
});
//////////////////////////////////////////////////////////////////////////////////////////
wow = new WOW(
        {
            boxClass: 'wow', // default
            animateClass: 'animated', // default
            offset: 100, // default
            mobile: false, // default
            live: true        // default
        }
)
wow.init();
//////////////////////////////////////////////////////////////////////////////////////////

$("#top").click(function () {
    $("html,body").animate({scrollTop: 0}, 500);
});
$(window).scroll(function () {
    if ($(window).scrollTop() > 200) {
        $("#top").fadeIn(500);
    } else {
        $("#top").fadeOut(500);
    }
});
///////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////
