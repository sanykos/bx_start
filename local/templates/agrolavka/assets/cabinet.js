$(function() {
	var url = window.location.href.replace("http://","").replace("https://","");
	jQuery('.account-menu dd a').each(function(){
		if(url.indexOf(jQuery(this).attr('href').replace("http://","").replace("https://","")) + 1){
			jQuery('.account-menu dd a.font-weight-bold').removeClass('font-weight-bold');
			jQuery(this).addClass('font-weight-bold');
		}
	});
	jQuery('.cabinet-form-edit').click(function(){
		var container = jQuery(this).closest('.cabinet-wrapper');
		jQuery('.cabinet-form-div,.cabinet-form',container).toggle();
		return false;
	});
	jQuery('.card-item__history__more_btn').click(function() {
		jQuery('span',this).toggle();
		jQuery(this).closest('.card-item__history').find('.card-item__history__more').slideToggle();
		return false;
	});


	// Редактируем профиль

	function errorMessages(message) {
        return `<div class="errortext">${message}</div>`;
     }

	$('body').on('submit', '.cabinet-form', function() {
		$form = $(this);
		let data = $form.serialize(),
			name = $form.find('#cabinet-name').val(),
			lastName = $form.find('#cabinet-lastname').val(),
			secondName = $form.find('#cabinet-secondname').val(),
			email = $form.find('#cabinet-email').val(),
			phone = $form.find('#cabinet-phone').val(),
			male = $form.find('#cabinet-gender-male'),
			female = $form.find('#cabinet-gender-female'),
			date = $form.find('#cabinet-birthday').val(),
			container = $form.closest('.cabinet-wrapper');
			sex = '',
			flag = true;

			let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
				phonePatter = /^((\+7|7|8)+([0-9]){10})$/,
				datePatter = /^([0-9]{2})\.([0-9]{2})\.([1-2][0-9]{3})$/,
				namePattern = /^[a-zA-Zа-яА-Я]+$/,
				lastNamePattern = /^[a-zA-Zа-яА-Я]+$/,
				secondNamePattern = /^[a-zA-Zа-яА-Я]+$/,
				errMsg = '';

			if(male.prop('checked'))
				sex = male.val();

			if(female.prop('checked'))
				sex = female.val();
	
				if(email !== '' && !emailPattern.test(email)) {
					errMsg = 'Введите корректный email';
					flag = false;
					$('body').append(errorMessages(errMsg));
				}else if(phone !== '' && !phonePatter.test(phone)) {
					//console.log('phoneerr');
					errMsg = 'Введите корректный телефон';
					flag = false;
					$('body').append(errorMessages(errMsg));
				}else if(date !== '' && !datePatter.test(date)) {
					errMsg = 'Введите корректную дату';
					$('body').append(errorMessages(errMsg));
					flag = false;
				}else if(name !== '' && !namePattern.test(name)) {
					errMsg = 'Введите корректное имя';
					flag = false;
					$('body').append(errorMessages(errMsg));
				}else if(lastName !== '' && !lastNamePattern.test(lastName)) {
					errMsg = 'Введите корректную фамилию';
					flag = false;
					$('body').append(errorMessages(errMsg));
				}else if(secondName !== '' && !secondNamePattern.test(secondName)) {
					errMsg = 'Введите корректное отчество';
					flag = false;
					$('body').append(errorMessages(errMsg));
				}else if(name == '' && 
						lastName == '' && 
						secondName == '' && 
						email =='' && 
						phone == '' &&
						date == '' && 
						sex == '') {
					errMsg = 'Все поля пустые';
					$('body').append(errorMessages(errMsg));
					flag = false;
				}else {
					flag = true;
				}

			//birthday = $form.find()
			

		if(flag) {
			$.ajax({
				type: 'POST',
				url: '/local/templates/agrolavka/ajax/editprofile.php',
				data: data,
				dataType: 'json',
				success: function(data) {
					if(!$.isEmptyObject(data)) {
						let fullname = '';
						for(key in data) {
							switch(key){
								case 'LAST_NAME':
									fullname+=data[key]+' ';
								break;
								case 'NAME':
									fullname+=data[key]+' ';
								break;
								case 'SECOND_NAME':
									fullname+=data[key];
								break;
								case 'SECOND_NAME':
									fullname+=data[key];
								break;
								case 'EMAIL':
									container.find('.email-value').text(data[key]);
								break;
								case 'PERSONAL_PHONE':
									container.find('.phone-value').text(data[key]);
								break;
								case 'PERSONAL_BIRTHDAY':
									container.find('.date-value').text(data[key]);
								break;
								case 'PERSONAL_GENDER':
									if(data[key] == 'F')
										container.find('.gender-value').text('Женский');
									else
									    container.find('.gender-value').text('Мужской');
								break;
							}
						}
						container.find('.fullname-value').text(fullname);
						$('.cabinet-form-div,.cabinet-form',container).toggle();
					}
				},
				error: function(err) {
					console.log(err);
				}

			})
		}

		return false;

	});


	// Повтор заказа
	$('body').on('click', '.repeat-order', function(e){
		//$cancel = confirm("Вы уверены, что хотите повторить заказ?");
		var id = $(this).data('order');
		$box = $(this).closest('.card-item__history');
		$item = $box.find('.card-item__history__more__item');

			var sendData = {
				id: id 
			};
			$.ajax({
				url: '/local/templates/agrolavka/ajax/order-repeat.php',
				type: 'POST',
				data: ({
					sendData: sendData
				}),
				dataType: "json",
				success: function(data) {
					if(data.success == 'success' && data.old_cart.success == 'success') {
						window.location.replace("/personal/cart");
					}else {
						console.log(data);
					}
				},
				error: function(err) {
					console.log(err);
				}
			})


		return false;
	});



});