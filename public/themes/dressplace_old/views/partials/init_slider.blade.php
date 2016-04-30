<script type="text/javascript">
    var flexSlider = $('.flexslider');

    $(document).ready(function () {
        //Init Slider
        flexSlider.flexslider({
                                  animation: "slide",
                                  easing: 'swing',
                                  animationSpeed: 1000,
                                  touch: true,
                                  keyboard: true,
                                  animationLoop: true,
                                  slideshow: true,
                                  slideshowSpeed: 7000,
                                  initDelay: 0,
                                  pauseOnHover: true,
                                  mousewheel: false,
                                  smoothHeight: true,
                                  start: function(){
                                      $('.slider-holder').removeClass('hidden');
                                      flexsliderResize();
                                  }
                              });


        var resizeEnd;
        $(window).on('resize', function () {
            clearTimeout(resizeEnd);
            resizeEnd = setTimeout(function () {
                flexsliderResize();
            }, 250);
        });
    });

    $(window).on("orientationchange", function () {
        flexsliderResize();
    });

    function flexsliderResize() {
        if (flexSlider.length > 0) {
            flexSlider.data('flexslider').resize();
        }
    }
</script>