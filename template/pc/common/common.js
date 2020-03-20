var hstj = new Swiper('.hs_tj_box', {
    navigation: {
        nextEl: '.swiper-button-nexthstj',
        prevEl: '.swiper-button-prevhstj',
    },

    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
    },
});



//children('.p_dis')

$(function () {

    $(".hs_n_nav>div>a").hover(function () {
        $(this).addClass("pulse");
    },function () {
        $(this).removeClass("pulse");
    })

    $(".tj_hs_n>a").hover(function () {
        $(this).children('span').addClass("fadeInLeft");
    },function () {
        $(this).children('span').removeClass("fadeInLeft");
    })

    $(".xingwen_li>.swiper-slide").hover(function () {
        $(this).addClass("pulse");
    },function () {
        $(this).removeClass("pulse");
    })

})






