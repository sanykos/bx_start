// console.log('main');


$(function() {
	function it_size(){
		var $it = jQuery('.it>.card.card-item');
		$it.height($it.parent().prev().find('.card.card-item').height());
	}
	it_size();
	$( document ).ready(function() {
		it_size();
		jQuery('body').on('click','.sort-price__view>a:nth-child(1)',function(){
			jQuery('.sort-price__view>a').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('.catalog-section').removeClass('catalog-section__list');
			it_size();
			if($(this).hasClass('active'))
				localStorage.setItem('state', 'grid');
			else
				localStorage.removeItem('state');
			return false;
		});
		jQuery('body').on('click','.sort-price__view>a:nth-child(2)',function(){
			jQuery('.sort-price__view>a').removeClass('active');
			jQuery(this).addClass('active');
			jQuery('.catalog-section').addClass('catalog-section__list');
			it_size();
			if($(this).hasClass('active'))
				localStorage.setItem('state', 'list');
			else
				localStorage.removeItem('state');
			return false;
		});
	});

	switch(localStorage['state']) {
		case 'list':
			$('.sort-price__view>a').removeClass('active');
			$('.sort-price__view>a:nth-child(2)').addClass('active');
			$('.catalog-section').addClass('catalog-section__list');
			it_size();
		break;
		case 'grid':
			$('.sort-price__view>a').removeClass('active');
			$('.sort-price__view>a:nth-child(1)').addClass('active');
			$('.catalog-section').removeClass('catalog-section__list');
			it_size();
		break;
	}

	$( window ).resize(function() {
		it_size();
	});
	$( "#target" ).scroll(function() {
		it_size();
	});
	window.onload = function() {
		it_size();
	};
});