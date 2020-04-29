// detailSLider
$(function() {
    // detailSlider
    var defaultWidth = $(window).width(),
        detailSlider;
        function checkWidth() {
            var vertical = true,
                loop = false,
                controls = false,
                gallery = true,
                pager = true;
            if($(window).width() < 1200) {
                controls = true;
                vertical = false;
                loop = true;
                gallery = false;
                pager = false;
            }
            if($('.detailSlider').length > 0 && detailSlider) {
                detailSlider.destroy();
            }
            detailSlider = $('.detailSlider').lightSlider({
                gallery:gallery,
                item:1,
                loop: loop,
                controls: controls,
                vertical: vertical,
                // adaptiveHeight: true,
                verticalHeight:330,
                vThumbWidth: 90,
                pager: pager,
                thumbItem:4,
                thumbMargin:2,
                slideMargin:0 ,
            });
        }
        checkWidth();
        $(window).resize(function() {
            if (defaultWidth != $(window).width()) {
                defaultWidth = $(window).width();
                checkWidth();
             }
        });
});

// Tabs
$(function() {
    $('.tabs-menu').on('click', 'li:not(.active)', function(e) {
        e.preventDefault();
        $(this)
        .addClass('active')
        .siblings()
        .removeClass('active')
        .closest('.tabs__box')
        .find('.tabs-content')
        .removeClass('active')
        .eq($(this).index())
        .addClass('active');
    });
});

// share socials
$(function() {
    $('.share-container').on('click', function(e) {
        e.preventDefault();
        $(this)
        .closest('.share-social-box')
        .find('.share-social-list')
        .stop()
        .fadeIn(300);
    })

    $(document).on('click', function(e) {
        if($(e.target).closest('.share-container').length != 0 || $(e.target).closest('.share-social-list').length != 0) return;
        $('.share-social-list').stop().fadeOut(300);
    })
});


$(function(){
    if($('.recommended-products-section.detail-products-section').children().length == 0) {
        $('.section-title.section-title-h4.rec__title').css({display: "none"});
        $('.recommended-products-section.detail-products-section').css({display: "none"});
    }   
});