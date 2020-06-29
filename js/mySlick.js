$(document).ready(function()
{
    $('.thing').slick({
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1000
    });

    $('.three').slick({
        dots: true,
        arrows: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 1000
    });

    $('.wideSlider').slick({
        dots: false,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 1500
    });
});