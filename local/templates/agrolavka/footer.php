
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="w-100">
				<div class="row">
					<div class="col-12 col-lg-3">
						<div class="mb-4">
							<a href="/">
							<?
								$APPLICATION->IncludeFile(
									SITE_DIR.'include/company_logo.php',
									array(),
									array(
										'MODE'=>'html'
									)
								)
							?>
							</a>
						</div>
						<div class="mb-4 text-gray">
						<?$APPLICATION->IncludeFile(
										SITE_DIR.'include/copyright.php',
										array(),
										array(
											'MODE'=>'html'
										)
								) ?>
							
						</div>
					</div>
					<div class="d-none d-sm-block col-sm-12 col-lg-6 col-xl-7">
						<div class="row">
							<div class="col-sm-7 col-md-7">
								<div class="f-catal-title">Каталог товаров</div>
									<?$APPLICATION->IncludeComponent(
										"bitrix:menu",
										"catalog_menu",
										Array(
											"ALLOW_MULTI_SELECT" => "N",
											"CHILD_MENU_TYPE" => "left",
											"DELAY" => "N",
											"MAX_LEVEL" => "1",
											"MENU_CACHE_GET_VARS" => array(0=>"",),
											"MENU_CACHE_TIME" => "3600",
											"MENU_CACHE_TYPE" => "N",
											"MENU_CACHE_USE_GROUPS" => "Y",
											"ROOT_MENU_TYPE" => "footer_catalog_menu",
											"USE_EXT" => "N"
										)
									);?>
								
							</div>
							<div class="col-sm-5 col-md-5">
							<?$APPLICATION->IncludeComponent(
								"bitrix:menu", 
								"footer_menu", 
								array(
									"ALLOW_MULTI_SELECT" => "N",
									"CHILD_MENU_TYPE" => "top",
									"DELAY" => "N",
									"MAX_LEVEL" => "1",
									"MENU_CACHE_GET_VARS" => array(
									),
									"MENU_CACHE_TIME" => "3600",
									"MENU_CACHE_TYPE" => "A",
									"MENU_CACHE_USE_GROUPS" => "Y",
									"ROOT_MENU_TYPE" => "footer_menu",
									"USE_EXT" => "N",
									"COMPONENT_TEMPLATE" => "footer_menu"
								),
								false
							);?>					
							</div>					
						</div>				
					</div>
					<div class="f-right col-12 col-lg-3 col-xl-2">
						<span class="work-time">
							<?$APPLICATION->IncludeFile(
										SITE_DIR.'include/schedule.php',
										array(),
										array(
											'MODE'=>'html'
										)
								) ?>
							<?$APPLICATION->IncludeFile(
										SITE_DIR.'include/telephone.php',
										array(),
										array(
											'MODE'=>'html'
										)
								) ?>
							
						</span>
						<span class="feed-mail">
						<?$APPLICATION->IncludeFile(
										SITE_DIR.'include/company_mail.php',
										array(),
										array(
											'MODE'=>'html'
										)
								) ?>
						</span>
						<?$APPLICATION->IncludeComponent(
							"bitrix:eshop.socnet.links",
							"big_squares",
							array(
								"VKONTAKTE" => "https://vk.com/kormolavka",
								// "INSTAGRAM" => "https://instagram.com/1CBitrix/"
							),
							false,
							array(
								"HIDE_ICONS" => "N"
							)
						);?>
						<span class="valutes">
							<img src="http://agrolavka-shop.ru/images/logo_visa.png">
							<img src="http://agrolavka-shop.ru/images/logo_mc.png">
						</span>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-lg-6 mt-3">
						<div class="row">
							<div class="col-12 col-lg-6 mt-2">
								<a href="#" target="_blank" class="text-gray">Политика обработки персональных данных</a>
							</div>
							<div class="col-12 col-lg-6 mt-2">
								<a href="#" target="_blank" class="text-gray">Обратная связь</a>
							</div>
						</div>
					</div>
					<div class="f-right text-gray col-12 col-lg-6 mt-4">
						Создание сайта <a href="https://aleksinsky.ru/" target="_blank" title="Создание сайтов СПб" class="text-gray">aleksinsky.ru</a>
					</div>
				</div>
			</div>
		</div>
	</footer>
</div>

<!-- add to basket modal -->
<div class="modal fade" id="addToBasketModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content border-radius border-gray">
			<div class="modal-header border-bottom-0 pt-4 pr-4 pl-4 pb-0">
				<h5 class="modal-title" id="exampleModalLongTitle"></h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer border-top-0 pb-4 pr-4 pl-4 pb-4">
				<div class="w-100">
					<div class="row justify-content-center align-items-center">
						<div class="col pt-3">
							<div class="subtotal text-gray small">В корзине <span class="total_string">0 товаров</span> <br>на сумму <span class="sum_popup">0 р.</span></div>
						</div>
						<div class="col col-md-auto pt-3">
							<a href="#" data-dismiss="modal">Продолжить&nbsp;покупки</a>
						</div>
						<div class="col col-md-auto pt-3">
							<a href="/personal/cart/" class="btn btn-secondary btn-round orange-gradient border-0">Перейти в корзину</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Login modal -->
<div class="modal loginModal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content border-radius border-gray">
			<div class="modal-header border-bottom-0 pt-4 pr-4 pl-4 pb-0">
				<h5 class="modal-title" id="exampleModalLongTitle">Войти в личный кабинет</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<?$APPLICATION->IncludeComponent("bitrix:system.auth.form", "default", Array(
					"FORGOT_PASSWORD_URL" => "/auth/forget.php",	// Страница забытого пароля
						"PROFILE_URL" => "/personal/",	// Страница профиля
						"REGISTER_URL" => "/auth/registration.php",	// Страница регистрации
						"SHOW_ERRORS" => "Y",	// Показывать ошибки
					),
					false
				);?>
			</div>
		</div>
	</div>
</div>
<!-- Register modal -->
<div class="modal registerModal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content border-radius border-gray">
			<div class="modal-header border-bottom-0 pt-4 pr-4 pl-4 pb-0">
				<h5 class="modal-title" id="exampleModalLongTitle">Регистрация</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body p-4">
				<div class="register-form__box">
				<form method="post" class="registration-form" name="registrationform">
					<div class="form-group">
						<label for="" class="bx-soa-custom-label">Ведите email</label>
						<input type="text" id="reg_login_field" class="form__control" name="email">
					</div>
						<div class="form-group">
							<label for="" class="bx-soa-custom-label">Введите пароль</label>
							<input type="password" id="reg_passwd_field" class="form__control" name="password">
						</div>
						<div class="form-group">
							<label for="" class="bx-soa-custom-label">Подтвердите пароль</label>
							<input type="password" id="reg_passwd_confirm_field" class="form__control" name="password_confirm">
						</div>
						<div class="captcha-group">
						<? $CaptchaCode = htmlspecialcharsbx($APPLICATION->CaptchaGetCode()); ?>
							<div class="capcha_img">
								<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$CaptchaCode?>" width="160" height="40" alt="CAPTCHA" />
							</div>
							<div class="captcha-img-update">
								<div class="capchatext">
									<label for="" class="bx-soa-custom-label">Код с картинки</label>
									<input type="text" class="form__control" name="captcha_word">
									<input type="hidden" name="captcha_sid" class="captcha_sid" value="<?=$CaptchaCode?>">
								</div>
								<div class="capcha_button">
									<button type="button" class="btn capcha-button">Обновить</button>
								</div>	
							</div>
							
						</div>
						<input type="submit" name="register_submit_button" class="registration-btn btn-round"/>
					</form>
					<div class="or-delimeter__box">
						<div class="or-delimeter">
							или
						</div>
					</div>
					<a href="#" class="login-page-redir modal-login-btn btn-round" data-toggle="modal" data-target="#loginModal">Войти</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>