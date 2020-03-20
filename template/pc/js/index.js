window.onscroll=function(){
    var topScroll = get_scrollTop_of_body();//滚动的距离,距离顶部的距离
    var bignav = document.getElementById("top_nav");//获取到导航栏id
    if(topScroll > 152){ //当滚动距离大于250px时执行下面的东西
        bignav.style.position = 'fixed';
        bignav.style.top = '0';
        bignav.style.zIndex = '9999';
        bignav.style.width = '100%';
        bignav.classList.add("yy");

    }else{//当滚动距离小于250的时候执行下面的内容，也就是让导航栏恢复原状
        bignav.style.position = 'static';
        bignav.classList.remove("yy");
    }
}
/*解决浏览器兼容问题*/
function get_scrollTop_of_body(){
    var scrollTop;
    if(typeof window.pageYOffset != 'undefined'){//pageYOffset指的是滚动条顶部到网页顶部的距离
        scrollTop = window.pageYOffset;
    }else if(typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat')        {
        scrollTop = document.documentElement.scrollTop;
    }else if(typeof document.body != 'undefined'){
        scrollTop = document.body.scrollTop;
    }
    return scrollTop;
}







var banner = new Swiper('.banner', {
    autoHeight: true, //enable auto height
    spaceBetween: 0,

    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

//案例滚动
var anli = new Swiper('.al_box', {
    slidesPerView: "auto",
    spaceBetween: 0,
    centeredSlides: true,
    loop: true,
    navigation: {
        nextEl: '.swiper-button-next-al',
        prevEl: '.swiper-button-prev-al',
    },
});
//环境滚动
var hj = new Swiper('.hj_box', {
    slidesPerView: "auto",
    spaceBetween: 22,
    navigation: {
        nextEl: '.swiper-button-next-hj',
        prevEl: '.swiper-button-prev-hj',
    },
});
//荣誉滚动
var ry = new Swiper('.ry_box', {
    slidesPerView: "auto",
    spaceBetween: 25,
});











