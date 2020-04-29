$(function() {
	
	/* VARS */
	var homeSlider,
		categoriesSlider,
		recommendedProducts,
		manufactures,
		recentProducts;
	
	/* FUNCTIONS */
	function home_homeSlider_slider(){
		homeSlider = $('.home-main-slider .home-slider').lightSlider({
			item:1,
			slideMove:1,
			slideMargin:0,
			controls:1,
			pager:0,
			loop:true,
		});
	}
	function home_mainCategories_slider(){
		categoriesSlider = $('.home-main-categories .categories-slider').lightSlider({
			item:7,
			slideMove:7,
			slideMargin:0,
			controls:0,
			responsive : [
				{
					breakpoint:1199,
					settings: {
						item:5,
						slideMove:5,
					}
				},
				{
					breakpoint:991,
					settings: {
						item:4,
						slideMove:4,
					}
				},
				{
					breakpoint:767,
					settings: {
						item:3,
						slideMove:3,
					}
				},
				{
					breakpoint:575,
					settings: {
						item:2,
						slideMove:2,
					}
				}
			]
		});
	}
	function home_recommendedProducts_slider(){
		recommendedProducts = $('.recommended-products').lightSlider({
			item:4,
			slideMove:4,
			slideMargin:30,
			onAfterSlide: function (el) {
				var $index = recommendedProducts.getCurrentSlideCount();
				if($index==1){
					$('.recommended-products').parent().find('.lSPrev').hide();
				} else {
					$('.recommended-products').parent().find('.lSPrev').show();
				}
			},
			responsive : [
				{
					breakpoint:1199,
					settings: {
						item:3,
						slideMove:3,
					}
				},
				{
					breakpoint:991,
					settings: {
						item:2,
						slideMove:2,
					}
				},
				{
					breakpoint:768,
					settings: {
						item:1,
						slideMove:1,
					}
				}
			]
		});
		if($('.recommended-products').length>0){
			var $index = recommendedProducts.getCurrentSlideCount();
			if($index==1){
				$('.recommended-products').parent().find('.lSPrev').hide();
			} else {
				$('.recommended-products').parent().find('.lSPrev').show();
			}
		}
	}
	function home_manufactures_slider(){
		manufactures = $('.manufactures').lightSlider({
			item:8,
			slideMove:8,
			slideMargin:30,
			pager:0,
			onAfterSlide: function (el) {
				var $index = manufactures.getCurrentSlideCount();
				if($index==1){
					$('.manufactures').parent().find('.lSPrev').hide();
				} else {
					$('.manufactures').parent().find('.lSPrev').show();
				}
			},
			responsive : [
				{
					breakpoint:1199,
					settings: {
						item:7,
						slideMove:7,
					}
				},
				{
					breakpoint:991,
					settings: {
						item:5,
						slideMove:5,
					}
				},
				{
					breakpoint:768,
					settings: {
						item:4,
						slideMove:4,
					}
				},
				{
					breakpoint:576,
					settings: {
						item:2,
						slideMove:2,
					}
				}
			]
		});
		if($('.manufactures').length>0){
			var $index = manufactures.getCurrentSlideCount();
			if($index==1){
				$('.manufactures').parent().find('.lSPrev').hide();
			} else {
				$('.manufactures').parent().find('.lSPrev').show();
			}
		}
	}
	function home_recentProducts_slider(){
		recentProducts = $('.recent-products').lightSlider({
			item:8,
			slideMove:8,
			slideMargin:30,
			controls:0,
			responsive : [
				{
					breakpoint:1199,
					settings: {
						item:7,
						slideMove:7,
					}
				},
				{
					breakpoint:991,
					settings: {
						item:5,
						slideMove:5,
					}
				},
				{
					breakpoint:768,
					settings: {
						item:4,
						slideMove:4,
					}
				},
				{
					breakpoint:576,
					settings: {
						item:2,
						slideMove:2,
					}
				}
			]
		});
	}
	function home_autoheight(){
		var $headH = 0,
			$textH = 0;
		jQuery( ".home-articles .articles>div:visible" ).each(function( index ) {
			if(jQuery(this).find('.article-title').outerHeight()>$headH){
				jQuery(this).find('.article-title').removeAttr('style');
				$headH = jQuery(this).find('.article-title').outerHeight();
			}
			if(jQuery(this).find('.article-text').outerHeight()<$textH || $textH == 0){
				jQuery(this).find('.article-text').removeAttr('style');
				$textH = jQuery(this).find('.article-text').outerHeight();
			}
		});
		jQuery( ".home-articles .articles>div:visible" ).each(function( index ) {
			var $linesH = Math.ceil($headH/(14*1.15*1.2)),
				$linesT = Math.ceil($textH/(14*1.15*1.2));
			jQuery(this).find('.article-title').attr('style','height:'+$headH+'px;-webkit-line-clamp:'+$linesH);
			jQuery(this).find('.article-text').attr('style','height:'+$textH+'px;-webkit-line-clamp:'+$linesT);
		});
	}
	
	/* ----------------------------------------------------- */
	
	if($('.home-slider').length>0) home_homeSlider_slider();
	if($('.categories-slider').length>0) home_mainCategories_slider();
	if($('.recommended-products').length>0) home_recommendedProducts_slider();
	if($('.manufactures').length>0) home_manufactures_slider();
	if($('.recent-products').length>0) home_recentProducts_slider();
	home_autoheight();
	
	$( window ).resize(function() {
		if(homeSlider) {
			homeSlider.destroy();
			home_homeSlider_slider();
		}
		if(categoriesSlider) {
			categoriesSlider.destroy();
			home_mainCategories_slider();
		}
		if(recommendedProducts) {
			recommendedProducts.destroy();
			home_recommendedProducts_slider();
		}
		if(manufactures) {
			manufactures.destroy();
			home_manufactures_slider();
		}
		if(recentProducts) {
			recentProducts.destroy();
			home_recentProducts_slider();
		}
		home_autoheight();
	});
	
	jQuery('body').on('click','.main-catalog-tab a',function(){
		var div = jQuery(this).closest('.home-main-catalog'),
			data = jQuery(this).attr('title');
		jQuery('.main-catalog-tab.active',div).removeClass('active');
		jQuery('.catalog-items.active',div).removeClass('active').hide();
		jQuery('.catalog-items[data-title="'+data+'"]',div).addClass('active').fadeIn();
		jQuery(this).closest('.main-catalog-tab').addClass('active');
		return false;
	});
});