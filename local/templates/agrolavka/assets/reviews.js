class Feeds {
	constructor(par = {}) {
		this.params = {
			id: par.id || $('.card-detail, .developer-section').attr('data-id'),
			sort: 'asc',
			count: 5,
			page: 1,
			byStar: false,
			IBLOCK: par.IBLOCK || 15,
			FEED: par.FEED || 5,
			TYPE: par.TYPE || 'reviews',
			Type : typeof par.TYPE != 'undefined' ? par.TYPE.charAt(0).toUpperCase() + par.TYPE.slice(1) : 'Reviews'
		}
		
		this.props = {
			all:0,
			loadType: 'load',
			loaded : false
		}

		this.get()
	}
	
	get() {
		let that = this
		var request = BX.ajax.runComponentAction('alsky:reviews', 'reviews', {
		mode: 'class',
		data: that.params
		});

		request.then(function(response){
		console.log(response)
		if (response.status == 'success') {
			that.response = response
			that.updateContent()
			that.updatePages()
			that.updateDIV()
			if (!that.props.loaded) 
			{
				that.updateUI()
				that.getStars()
			}
			that.loadGallery()
			that.props.loaded = true
		}
		else {
			$('[data-action="show'+that.params.Type+'More"]').hide()
			that.setForm()
		}
		},
		function(response) {
		console.log(response)
		$('[data-action="show'+that.params.Type+'More"]').hide()
		that.setForm()
		})		
	}
	
	getStars() {
		let IBLOCK = this.params.IBLOCK
		let that = this
		var request = BX.ajax.runComponentAction('alsky:reviews', 'rating', {
		mode: 'class',
		data: {
			id: that.params.id,
			IBLOCK
		}
		});

		request.then(function(response){
		console.log(response)
		if (response.status == 'success') {
			for (let key in response.data) {
				if (key == 'width') {
					$('[data-action="ratings-width"]').css('width', response.data.width+'%')
				}
				else {
					$('[data-action="'+key+'"]').not('.active').text(response.data[key]).attr('data-found', response.data[key])
				}
			}
		}
		},
		function(response) {
		console.log(response)
		})	
	}
	
	updatePages() {
		this.props.all = this.response.data.found != this.props.all ? this.response.data.found : this.props.all
			$('[data-action="show'+this.params.Type+'More"]').attr('data-all', this.props.all).attr('data-page', this.params.page)
			console.log(this)
			if (this.params.count*this.params.page >= this.props.all || this.response.data.found <=this.params.count ) {
				$('[data-action="show'+this.params.Type+'More"]').hide()
			}	
	}
	
	updateContent() {
			this.sectionType = '.'+this.params.TYPE+'-list';
			if (this.props.loadType == 'updating') {
				$(this.sectionType).append(this.response.data.html)
			}
			else {
				$(this.sectionType).html(this.response.data.html)
			}		
	}
	
	updateDIV() {
		$('[data-tab="'+this.params.TYPE+'"]').attr('data-status', 'loaded')
		$('[data-tab="'+this.params.TYPE+'"]').data('feed', this)
		this.DIV = $('[data-tab="'+this.params.TYPE+'"]')
	}
	
	updateUI() {
		let that = this
		this.DIV.find('select[name="reviews_sort"]').on('change', function() {
			that.params.sort = $(this).val()
			that.params.page = 1
			that.props.loadType = 'load'
			$('[data-action="show'+that.params.Type+'More"]').show().attr('data-page', 1)
			that.get()
			console.log('updates')
		})
		
		
		this.DIV.find('[data-action*="ratings-"]').on('click', function(elem) {
			if ($(this).text() == 0) return false;	
			that.DIV.find('[data-action*="ratings-"]').removeClass('active')
			if ($(this).text() != 'Сбросить') 
			{
			var elem = $(this) 
			$(this).addClass('active').text('Сбросить')
			that.params.byStar = $(this).attr('data-action')
			that.DIV.find('[data-action*="ratings-"]').removeClass('active').each(function() {
				if ($(this).attr('data-action') != elem.attr('data-action')) {
					$(this).text($(this).attr('data-found'))
				}
			})
			}
			else {
			that.params.byStar = 0
			$(this).text($(this).attr('data-found'))
			}
			that.params.page = 1
			that.props.loadType = 'load'
			$('[data-action="show'+that.params.Type+'More"]').show().attr('data-page', 1)			
			that.get()			
		})
		
		this.setForm()
	}
	
	//форма для вопроса
	setForm() {
		var that = this
		console.log($('[data-action="submit-'+that.params.Type+'"]'))
		$('[data-action="submit-'+that.params.Type+'"]').submit(function(e) {
			e.preventDefault()
			var form = $('[data-action="submit-'+that.params.Type+'"]')
			var data = that.getFormData(this);
			var req = that.params.Type == 'Reviews' ? 'STARS' : 'VALUE' 
			var reqText = that.params.Type == 'Reviews' ? 'Укажите рейтинг' : 'Укажите текст' 
			if (!data[req]) {
				$('body').append('<div class="errortext">'+reqText+'</div>')
				setTimeout(function() {$('.errortext').remove()},5000)
				return false;
			}
			data['ID'] =  that.params.id
			data['FEED'] =  that.params.FEED
			data['IBLOCK'] =  that.params.IBLOCK
			var request = BX.ajax.runComponentAction('alsky:reviews', 'addReview', {
				mode: 'class',
				data: data
				});	

			request.then(function(response){
			console.log(response)
			if (response.status == 'success') {
				$('<div class="p-2">'+response.data.answer+'</div>').insertAfter('[data-action="submit-'+that.params.Type+'"]')
				form.remove()
			}
			},
			function(response) {
				console.log(response)
			})	
		})
	}
	
	nextPage() {
		this.props.loadType = 'updating'
		this.params.page = parseInt($('[data-action="show'+this.params.Type+'More"]').attr('data-page'))+1
		this.get()
	}
	
	loadGallery() {
			if ($('[data-action="reviews-images"]').length) {
				$('[data-action="reviews-images"]').lightGallery({
					thumbnail:true
				});
			}		
	}
	
	update() {
		return this
	}
	
	getFormData(form) {
		var data = { };
		$.each($(form).serializeArray(), function() {
					if (this.name.indexOf('[') > -1) {		
		if (typeof data[this.name.split('[')[0]] == 'undefined') data[this.name.split('[')[0]] = []
		data[this.name.split('[')[0]].push(this.value);
					}
					else {
						data[this.name] = this.value
					}
				});	
		return data;
	}
	
}

$('document').ready(function() {
	
	$('[data-action="questions"]').click(function(e) {
		if ($('[data-tab="'+$(this).attr('data-action')+'"]').attr('data-status') == 'loaded') return;
		let par = {
			'FEED': $(this).attr('data-feed'),
			'TYPE': 'questions'
		}
		if ($(this).attr('data-iblock')) {
			par['IBLOCK'] = $(this).attr('data-iblock')
		}
		let feed = new Feeds(par)		
	})
	
	$('[data-action="reviews"]').click(function(e) {
		if ($('[data-tab="'+$(this).attr('data-action')+'"]').attr('data-status') == 'loaded') return;
		let feed = new Feeds()	
	})
	
	
	$('[data-action="showQuestionsMore"], [data-action="showReviewsMore"]').click(function(e) {
		e.preventDefault()
		let feed = $(this).parents('.feeds-tab').data('feed')
		feed.nextPage()
	})
	
	if ($('[data-action="feedbacks"]').length) {
		let par = {
			'id': $('[data-action="feedbacks"]').attr('data-id'),
			'IBLOCK': $('[data-action="feedbacks"]').attr('data-iblock'),
		}
		console.log(par)
		let feed = new Feeds(par)			
	}
	
	
	$('body').on('click', '[data-action="review-likes"]', function(e) {
		e.preventDefault()
		var like = $(this)
		var type = $(this).attr('data-type')
		var id = $(this).parents('.reviews-item').attr('data-review')
		var count = $(this).find('[data-action="count"]')
		if (typeof getCookie('reviews_likes') == 'undefined' || typeof JSON.parse(getCookie('reviews_likes'))[id] == 'undefined') {
			var request = BX.ajax.runComponentAction('alsky:reviews', 'likes', {
			mode: 'class',
			data: {type, id}
			});	

		request.then(function(response){
		if (response.status == 'success') {
			count.text(response.data)
			let coo = typeof getCookie('reviews_likes') != 'undefined' ? JSON.parse(getCookie('reviews_likes')) : {};
			coo[id] = type
			like.addClass('active')
			setCookie('reviews_likes', JSON.stringify(coo), {'max-age': 3600*24*365});
		}
		},
		function(response) {
		console.log(response)
		})			
		}
	})
	
	// ответ на отзыв/вопрос
	$('body').on('submit', '[data-action="reply-review"]', function(e) {
		e.preventDefault()
		var form = $(this)
		var data = getFormData(this);
		files = [];
		for (let key in data) {
			if (key.indexOf('FEED_ATTACH') > -1) {
				files = data[key]
			}
		}
		data['FEED_ATTACH'] = files
		data['ID'] = $(this).parents('.reviews-item').attr('data-review')
		data['FEED'] = form.attr('data-feed')
		console.log(data)
		if (!data['VALUE']) {
			$('body').append('<div class="errortext">Поле текст не заполнено</div>')
			setTimeout(function() {$('.errortext').remove()},5000)
			return false;			
		}
		var request = BX.ajax.runComponentAction('alsky:reviews', 'addReply', {
			mode: 'class',
			data: data
			});	

		request.then(function(response){
			console.log(response)
		if (response.status == 'success') {
				$('<div class="p-2">'+response.data.answer+'</div>').insertAfter('[data-action="reply-review"]')
				form.remove()
		}
		},
		function(response) {
		console.log(response)
		})	
	})
	
	$('body').on('click', '[data-action="reply-formBtn"]', function() {
		$(this).parent().siblings('[data-action="reply-form"]').toggleClass('d-none')
	})
	
   BX.addCustomEvent('uploadFinish', function(res) {
      console.log(res); // тут инфо о файле, по сути нам нужен только его ID
   });
   
		$('[data-action="setrating"]').mousemove(function(event) {
			var width = parseInt(event.offsetX/$(this).width()*100)
			var stars = $(this).find('.green-gradient')
			if (width < 20)
			stars.css('width', '20%')
			else if (width >= 20 && width < 40)
			stars.css('width', '40%')
			else if (width >= 40 && width < 60)
			stars.css('width', '60%')
			else if (width >= 60 && width < 80)
			stars.css('width', '80%')
			else if (width >= 80)
			stars.css('width', '100%')												
			})
			$('[data-action="setrating"]').click(function(event) {
			var width = parseInt(event.offsetX/$(this).width()*100)
			var stars = $(this).find('.green-gradient')
			let val = '' 
			if (width < 20)
			val = 1
			else if (width >= 20 && width < 40)
			val = 2
			else if (width >= 40 && width < 60)
			val = 3
			else if (width >= 60 && width < 80)
			val = 4
			else if (width >= 80)
			val = 5
			val = $('[name="STARS"]').val() == val ? '' : val
			$('[name="STARS"]').val(val)
			})
			$('[data-action="setrating"]').mouseleave(function(event) {
			var stars = $(this).find('.green-gradient')
			if ($('[name="STARS"]').val())
			stars.css('width', $('[name="STARS"]').val()*20+'%')
			else
			stars.css('width', 0)	
			})
	
})

function getReviews(elem, custParams) {
		console.log($(elem))
		console.log($(elem).prop('tagName'))
		if ($(elem).prop('tagName') == 'SELECT' || $(elem).attr('data-action').indexOf('ratings-') > -1) {
			$('[data-action="showReviewsMore"]').show().attr('data-page', 1)
		}
		let data = custParams || {}
		let TYPE = typeof data.TYPE != 'undefined' ? data.TYPE : 'reviews'
		let Type = typeof data.TYPE != 'undefined' ? data.TYPE.charAt(0).toUpperCase() + data.TYPE.slice(1) : 'Reviews'
		let page = parseInt($('[data-action="show'+Type+'More"]').attr('data-page'))
		let count = parseInt($('[data-action="show'+Type+'More"]').attr('data-count'))
		let all = parseInt($('[data-action="show'+Type+'More"]').attr('data-all'))
		let byStar = $('[data-action*="ratings-"].active').length ? $('[data-action*="ratings-"].active').attr('data-action') : 0
		let IBLOCK = $(elem).attr('data-iblock') || $('[data-action="feedbacks"]').attr('data-iblock')
		console.log(byStar)
		params = {
			id: $('.card-detail').attr('data-id') || $('[data-action="feedbacks"]').attr('data-id'),
			sort: $('#reviews_sort').val(),
			count,
			page,
			byStar,
			IBLOCK,
		}
		var request = BX.ajax.runComponentAction('alsky:reviews', 'reviews', {
		mode: 'class',
		data: data || params
		});

		request.then(function(response){
		console.log(response)
		if (response.status == 'success') {
			
			console.log($('#reviews_sort').val())
			var sectionType = $(elem).attr('data-action') == TYPE || $(elem).attr('data-action') == 'show'+Type+'More' ? '.'+TYPE+'-list' : '.reviews-list'
			var all = response.data.found != all ? response.data.found : all
			$('[data-action="show'+Type+'More"]').attr('data-all', all)
			if (count*page >= all || response.data.found <=count ) {
				$('[data-action="show'+Type+'More"]').hide()
			}
			else {
				$('[data-action="show'+Type+'More"]').attr('data-page', page+1)
			}
			if ($(elem).attr('data-action') == 'show'+Type+'More') {
				$(sectionType).append(response.data.html)
			}
			else {
				$(sectionType).html(response.data.html)
			}
			
			if ($('[data-action="reviews-images"]').length) {
				$('[data-action="reviews-images"]').lightGallery({
					thumbnail:true
				});
			}
		}
		},
		function(response) {
		console.log(response)
		})
}

function getStars(elem) {
		let IBLOCK = $(elem).attr('data-iblock') || $('[data-action="feedbacks"]').attr('data-iblock')
		var request = BX.ajax.runComponentAction('alsky:reviews', 'rating', {
		mode: 'class',
		data: {
			id: $('.card-detail').attr('data-id') || $('[data-action="feedbacks"]').attr('data-id'),
			IBLOCK
		}
		});

		request.then(function(response){
		if (response.status == 'success') {
			for (let key in response.data) {
				if (key == 'width') {
					$('[data-action="ratings-width"]').css('width', response.data.width+'%')
				}
				else {
					$('[data-action="'+key+'"]').not('.active').text(response.data[key])
				}
			}
		}
		},
		function(response) {
		console.log(response)
		})	
}

function getFormData(form) {
		var data = { };
		$.each($(form).serializeArray(), function() {
					if (this.name.indexOf('[') > -1) {		
		if (typeof data[this.name.split('[')[0]] == 'undefined') data[this.name.split('[')[0]] = []
		data[this.name.split('[')[0]].push(this.value);
					}
					else {
						data[this.name] = this.value
					}
				});	
		return data;
}