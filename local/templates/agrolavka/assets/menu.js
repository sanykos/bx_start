$(function() {
	
	// header-search-btn
	jQuery('body').on('click','.header-icons_search a',function(){
		jQuery('.header-search').slideToggle();
		if(jQuery('#main-menu-btn').hasClass('btn-primary')) {
			jQuery('#main-menu-btn').find('svg').toggle();
			jQuery('#main-menu-btn').toggleClass('btn-secondary')
					.toggleClass('btn-primary')
					.toggleClass('orange-gradient')
					.toggleClass('green-gradient');
			jQuery('.main-menu').slideToggle();
		}
		return false;
	});
	
	jQuery(document).mouseup(function (e){
		var div = jQuery(".header-search"),
			btn = jQuery(".header-icons_search a");
		if (!div.is(e.target) && div.has(e.target).length === 0 && !btn.is(e.target) && btn.has(e.target).length === 0) {
			jQuery('.header-search').slideUp();
		}
	});
	
	// main-menu-btn
	jQuery('body').on('click','#main-menu-btn',function(){
		jQuery('.header-search').slideUp();
		jQuery(this).find('svg').toggle();
		jQuery(this).toggleClass('btn-secondary')
					.toggleClass('btn-primary')
					.toggleClass('orange-gradient')
					.toggleClass('green-gradient');
		jQuery('.main-menu').slideToggle();
		if(jQuery(this).hasClass('btn-primary')) {
			menu_height();
		}
		return false;
	});
	jQuery( window ).resize(function() {
		if(jQuery('.main-menu:visible').length>0){
			menu_height();
		}
	});
	jQuery('body').on('click','.main-menu-div .main-menu__questions > div > a',function(){
		jQuery('#main-menu-btn').find('svg').toggle();
		jQuery('#main-menu-btn').toggleClass('btn-secondary')
								.toggleClass('btn-primary')
								.toggleClass('orange-gradient')
								.toggleClass('green-gradient');
		jQuery('.main-menu').slideToggle();
		return false;
	});
	
	function menu_height(){
		var $mid, $flag=0, $full=0, $cols = 3, $arr = [],
			$row = jQuery('.main-menu-div .main-menu__categories > div > .row'),
			$w = $.documentWidth()+$.scrollbarWidth();
		if($w<1200) $cols = 2;
		if($w<992) $cols = 3;
		if($w<768) $cols = 2;
		$row.css('height','auto');
		$row.find('.col:visible').each(function( index ) {
			var $h = jQuery(this).outerHeight();
			$full+=$h;
			$arr.push($h);
		});
		$mid = Math.ceil($full/$cols);
		console.log($mid);
		while($flag<$cols-1){
			var $j = 0,
				$min = $mid,
				$max,
				$col = [];
			for($i=0;$i<$arr.length;$i++){
				if($col[$j]+$arr[$i] > $mid) {
					if($col[$j]<$min) $min = $col[$j];
					$j++;
				}
				if(!$col[$j])$col[$j] = 0;
				$col[$j]+=$arr[$i];
			}
			$max = Math.max.apply(null,$col);
			if($col.length>$cols) $mid = $min+$col[$col.length-1]; else $flag++;
		}
		$row.height(Math.ceil($max));
	}
	
});