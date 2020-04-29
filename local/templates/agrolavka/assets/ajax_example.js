document.addEventListener('DOMContentLoaded', function() {
	$('body').on('click', '[data-action="show-more"]', function() {
		console.log('click1')
		let nav = $(this)
		let navPar = $(this).parents('[data-type="lazyWrap"]')
		let page = $(this).attr('data-currentpage')
		let maxPage = $(this).attr('data-pagecount')
		if (parseInt(page) < parseInt(maxPage)) {
			navParams['PAGEN_1'] = parseInt(page)+1
			var request = BX.ajax.runComponentAction('bitrix:catalog.section', 'showMore', {
				data: navParams
			});
			
		// var params = new URLSearchParams();
		// for (let key in navParams) {
			// params.set(key, navParams[key])
		// }
		// params.set('action', 'showMore')
		// var request = fetch('/local/components/bitrix/catalog.section/ajax.php',
			// {
			// method: 'POST',
			// body:	params
			// }
		// )
			 
			// request.then(function(response){
				// return response.text()
			// })
			request.then(function(response){
				console.log(response)
				//console.log('response')
				if (response.data && typeof response.data.ajaxRejectData != 'undefined' && response.data.ajaxRejectData) {
					//$('.catalog-section').append(response.data.ajaxRejectData.items)
					$(response.data.ajaxRejectData.items).insertBefore('[data-type="lazyWrap"]')
						nav.attr('data-currentpage',navParams['PAGEN_1'])
				}
			},
			function(response) {
				console.log(response)
				//console.log('rs');
				if (response.data && typeof response.data.ajaxRejectData != 'undefined' && response.data.ajaxRejectData) {
					$(response.data.ajaxRejectData.items).insertBefore('[data-type="lazyWrap"]')
						nav.attr('data-currentpage',navParams['PAGEN_1'])
						if (parseInt(navParams['PAGEN_1']) >= parseInt(maxPage) ) navPar.hide()
				}
			})				
		}
		else {
			navPar.hide()
		}
	})
	
	$('body').on('click', '[data-action="add2basket"]', function(e) {
		e.preventDefault();
		let url = $(this).attr('href');
		var params = new URLSearchParams();
		params.set('ajax_basket', 'Y');
		var productname = $(this).data('productname');
		//$('#addToBasketModal').find('.modal-title').text(productname + ' успешно добавлен в корзину');
		//console.log($(this).data('productname'));
		fetch(url,
			{
			method: 'POST',
			body:	params
			}
		)
			.then(function(res) {
				return res.text()
			}, function() {
				return res.text()
			})
				.then(function(res) {
					console.log(res)
					var res = JSON.parse(res);
					updateCart()
					var title = res.STATUS == 'ERROR' ? productname + ' - не был добавлен в корзину. Причина: ' +res.MESSAGE : productname + ' - ' +res.MESSAGE
					console.log(res)
					console.log(title)
					$('#addToBasketModal').find('.modal-title').text(title)
					$('#addToBasketModal').modal();
				})
	})

})

	function updateCart() {
		console.log(cartData)
		if (typeof cartData == 'undefined') return;
		var params = new URLSearchParams();
		params.set('sessid', BX.bitrix_sessid());
		params.set('ajax', 'Y');
		for (let k in cartData) {
			if (k == 'arParams') {
				for (ar in cartData[k]) {
					params.set('arParams['+ar+']', cartData[k][ar])
				}
			}
			else {
			params.set(k, cartData[k])
			}
		}
		fetch(cartData.ajaxPath,
					{
					method: 'POST',
					body:	params
					}
				)
		.then(function(res) {return res.json()}, 
			function(err) {
				return err.json()
			})
		.then(function(res) {
				console.log(res)
				$('[data-action="cardInfo"]').attr('title', res.total_string+', сумма '+res.sum)
				$('[data-action="cardInfo"] .count').text(res.total)
				$('.total_string').text(res.total_string)
				$('.sum_popup').html(res.sum);
		},
			function(err) {
							console.log(err)
					}		
		)
	}
