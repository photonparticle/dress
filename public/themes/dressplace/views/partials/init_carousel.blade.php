<script type="text/javascript">
    $(document).ready(function () {
        //Init all carousels
        $('.carousel').slick({
                                 centerMode: false,
                                 cssEase: 'ease-in-out',
                                 fade: false,
                                 slidesToShow: 4,
                                 slidesToScroll: 4,
                                 arrows: true,
//                                 autoplay: true,
                                 autoplaySpeed: 3000,
                                 lazyLoad: 'progressive',
                                 dots: true,
                                 infinite: true,
                                 pauseOnHover: true,
                                 speed: 500,
                                 responsive: [
                                     {
                                         breakpoint: 1024,
                                         settings: {
                                             arrows: false,
                                             dots: true,
                                             slidesToShow: 3,
                                             slidesToScroll: 3
                                         }
                                     },
                                     {
                                         breakpoint: 768,
                                         settings: {
                                             arrows: false,
                                             dots: false,
                                             slidesToShow: 2,
                                             slidesToScroll: 2
                                         }
                                     },
                                     {
                                         breakpoint: 480,
                                         settings: {
                                             arrows: false,
                                             dots: false,
                                             slidesToShow: 1,
                                             slidesToScroll: 1
                                         }
                                     }
                                 ]
                             });
    });
</script>