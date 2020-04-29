$(function() {
    $('.loginModal .modal-registration-btn').attr('href', '#').attr('data-target', '#registerModal').attr('data-toggle', 'modal');
    $('.loginModal .modal-registration-btn').on('click', () => $('#loginModal').modal('hide'));

    // $('.registerModal .modal-login-btn').attr('href', '#').attr('data-target', '#loginModal').attr('data-toggle', 'modal');
     $('.registerModal .modal-login-btn').on('click', () => $('#registerModal').modal('hide'));

     function errorMessages(message) {
        return `<div class="errortext">${message}</div>`;
     }
    // Форма авторизации
    $('body').on('submit', '.bx-system-auth-form form', function() {
        $form  = $(this);
        //$form.find('input[]').foreach
        let login = $('#auth_login_field').val(),
            pswd = $('#auth_passwd_field').val(),
            errMsg = '',
            flag = true;

        if(login === '' && pswd === '') {
            flag = false;
            errMsg = 'Все поля должны быть заполнены';
            $('body').append(errorMessages(errMsg));
        }else if(login === '') {
            flag = false;
            errMsg = 'Введите логин';
            $('body').append(errorMessages(errMsg));
        }else if(pswd === '') {
            flag = false;
            errMsg = 'Введите пароль';
            $('body').append(errorMessages(errMsg));
        }else {
            flag = true;
        }

      //  deleteErrBlocks($('div.errortext'));
        
        if(flag) {
            $.ajax({
                type: 'POST',
                url: $form.attr('action'),
                data: $form.serialize(),
                dataType: 'json',
                success: function(data) {
                    if(data.type == 'error') {
                        $('body').append(errorMessages(data.message));
                        //deleteErrBlocks($('div.errortext'));
                        //console.log(data.message);
                    }else {
                        window.location = window.location;
                    }
                }
            });
        }
        return false;
    })

    // Форма регистрации
    $('body').on('submit', 'form.registration-form', function() {
        $form = $(this);
        let wrapper = $(this).closest('.register-form__box');
        let login = wrapper.find('#reg_login_field').val(),
            pswd = wrapper.find('#reg_passwd_field').val(),
            pswdConfirm =  wrapper.find('#reg_passwd_confirm_field').val();

        let emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            errMsg = '',
            flag = true;

            if(!emailPattern.test(login)) {
                errMsg = 'Введите корректный адрес электронной почты';
                flag = false;
                $('body').append(errorMessages(errMsg));
            }else if(pswd.length < 6) {
                errMsg = 'Пароль должен быть больше 6 символов';
                flag = false;
                $('body').append(errorMessages(errMsg));
            }else if(pswd != pswdConfirm) {
                errMsg = 'Пароли должны совпадать';
                flag = false;
                $('body').append(errorMessages(errMsg));
            }else {
                flag = true;
            }

            //deleteErrBlocks($('div.errortext'));

            if(flag) {
                $.ajax({
                    type:'POST',
                    url: '/local/templates/agrolavka/ajax/registration.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(data) {
                        if(data.status == 'error') {
                            $('body').append(errorMessages(data.message));
                        }else {
                            $('body').append(`<div class="successtext">${data.message}</div>`);
                            //console.log($form);
                            $form[0].reset();
                            setTimeout(function(){
                                window.location = window.location;
                            },5000);


                        }
                    },
                    error: function(err) {
                        console.log(err)
                    }
                });
            }
        
        return false;
    });


    // Для капчи
    $(".capcha-button").click(function(){
		$.getJSON('/local/templates/agrolavka/ajax/captcha_update.php', function(data) {
                $('.capcha_img img').attr('src','/bitrix/tools/captcha.php?captcha_sid='+data);
                $('.captcha_sid').val(data);
         });
         return false;
	})
});