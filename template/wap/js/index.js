//banner
var swiper1 = new Swiper('.banner', {
    autoHeight: true, //enable auto height
    spaceBetween: 0,
    effect : 'flip',
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
});
//康复
var swiper2 = new Swiper('.kf_box', {
    slidesPerView: "auto",
    spaceBetween: 20,
});
//团队
var swiper3 = new Swiper('.td_box', {
    slidesPerView: "auto",
    spaceBetween: 20,
    centeredSlides: true,
    loop: true,
});