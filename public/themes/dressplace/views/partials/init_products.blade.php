<script type="text/javascript">
    $('document').ready(function () {
        productEqualHeight();
    });

    function productEqualHeight() {
        var max_height = 0,
                title = $('.product-title');

        if(title.length > 0) {
            title.each(function () {
                if (max_height < $(this).height()) {
                    max_height = $(this).height();
                }
            });

            title.each(function () {
                $(this).css('min-height', max_height);
            });
        }
    }
</script>