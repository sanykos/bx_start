<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
if(!$USER->IsAuthorized()) LocalRedirect("/auth");
$APPLICATION->SetTitle("Личный кабинет");
?>

<?
/*Поля пользователя
	PERSONAL_GENDER = M/F
	EMAIL
	NAME - Имя
	LAST_NAME - Фамилия
	SECOND_NAME - Отчество
	PERSONAL_BIRTHDAY - Дата рождения
	PERSONAL_PHONE - Телефон
	PERSONAL_MOBILE - Мобльный
*/
//$rsUser = CUser::GetByID($USER->GetID());
//$arUser = $rsUser->Fetch();
//echo "<pre>"; print_r($arUser); echo "</pre>";


$rsUser = CUser::GetByID($USER->GetID());
$arUser = $rsUser->Fetch();
$user_name = $arUser['NAME'] ? $arUser['NAME'] : '';
$user_lastname = $arUser['LAST_NAME'] ? $arUser['LAST_NAME'] : '';
$user_secondname = $arUser['SECOND_NAME'] ? $arUser['SECOND_NAME'] : '';
$user_fullname = ($user_name == '' 
					&& $user_lastname == '' 
					&& $user_secondname == '') ? 
					'Не указано' : 
					$user_lastname.' '.$user_name.' '.$user_secondname;
$user_email = $arUser['EMAIL'];
$user_phone = $arUser['PERSONAL_PHONE'] ? $arUser['PERSONAL_PHONE'] : 'Не указано';
$user_birthday = $arUser['PERSONAL_BIRTHDAY'] ? $arUser['PERSONAL_BIRTHDAY'] : 'Не указано';
	switch($arUser['PERSONAL_GENDER']) {
		case 'F':
			$user_gender = 'Женский';
		break;
		case 'M':
			$user_gender = 'Мужской';
		break;
		default:
			$user_gender = 'Не указано';
	}

//help_arr($arUser);
//echo "<pre>"; print_r($arUser); echo "</pre>";
?>

<section class="account-section">
	<div class="w-100">
		<div class="row">
			<div class="account-menu col-12 col-md-4 col-lg-3">
				<?php echo file_get_contents($_SERVER['SCRIPT_URI'].'sect_sidebar.php')?>
			</div>
			<div class="col-12 col-md-8 col-lg-9">
				<div class="w-100">
					<div class="row">
						<div class="cabinet-wrapper col-12 col-sm-6 mb-5">
							<h5 class="section-title section-title-h5 mb-4">Личная информация</h5>
							<div class="cabinet-form-div">
								<div class="mt-2 mb-4">
									<div class="label">Фамилия, имя, отчество</div>
									<div class="value fullname-value"><?=$user_fullname?></div>
								</div>
								<div class="mt-2 mb-4">
									<div class="label">Почта</div>
									<div class="value email-value"><?=$user_email?></div>
								</div>
								<div class="mt-2 mb-4">
									<div class="label">Телефон</div>
									<div class="value phone-value"><?=$user_phone?></div>
								</div>
								<div class="mt-2 mb-4">
									<div class="label">Дата рождения</div>
									<div class="value date-value"><?=$user_birthday?></div>
								</div>
								<div class="mt-2 mb-5">
									<div class="label">Пол</div>
									<div class="value gender-value"><?=$user_gender?></div>
								</div>
								<div class="mb-4">
									<a href="#" class="text-secondary font-weight-bold cabinet-form-edit">Изменить личную информацию</a>
								</div>
							</div>
							<form method="post" class="cabinet-form" style="display:none">
								<div class="cabinet-form-textinput">
									<label>
										<span>Фамилия</span>
										<input id="cabinet-lastname" name="last_name" type="text"  value="<?=$user_lastname?>" placeholder="<?=$user_lastname?>">
									</label>
								</div>
								<div class="cabinet-form-textinput">
									<label>
										<span>Имя</span>
										<input id="cabinet-name" name="name" type="text" value="<?=$user_name?>" placeholder="<?=$user_name?>">
									</label>
								</div>
								<div class="cabinet-form-textinput">
									<label>
										<span>Отчество</span>
										<input id="cabinet-secondname" name="second_name" type="text" value="<?=$user_secondname?>" placeholder="<?=$user_secondname?>">
									</label>
								</div>
								<div class="cabinet-form-textinput">
									<label>
										<span>Почта</span>
										<input id="cabinet-email" name="email" type="mail" value="<?=$user_email?>" placeholder="<?=$user_email?>">
									</label>
								</div>
								<div class="cabinet-form-textinput">
									<label>
										<span>Телефон</span>
										<input id="cabinet-phone" name="phone" type="text" value="<?=$user_phone?>" placeholder="+79219999999">
									</label>
								</div>
								<div class="cabinet-form-textinput">
									<label>
										<span>Дата рождения</span>
										<input id="cabinet-birthday" name="birthday" type="text" value="<?=$user_birthday?>" placeholder="<?=$user_birthday?>">
									</label>
								</div>
								<div class="cabinet-form-radioinput d-flex justify-content-between align-items-center flex-wrap mb-3">
									<span class="mr-auto mb-2">Пол:</span>
									<label><input id="cabinet-gender-male" type="radio" name="sex" value="M" <?if($arUser['PERSONAL_GENDER'] == 'M'):?> checked="checked"<?endif?>><div class="pseudo-radio"></div>Мужской</label>
									<label><input id="cabinet-gender-female" type="radio" name="sex" value="F" <?if($arUser['PERSONAL_GENDER'] == 'F'):?> checked="checked"<?endif?>><div class="pseudo-radio"></div>Женский</label>
								</div>
								<div class="cabinet-form-submitinput d-flex justify-content-between align-items-center flex-wrap">
									<button class="btn text-secondary cabinet-form-edit">Отменить</button>
									<button class="btn btn-outline-secondary" type="submit">Сохранить</button>
								</div>
							</form>
						</div>
						<div class="cabinet-wrapper col-12 col-sm-6 mb-5">
							<h5 class="section-title section-title-h5 mb-4">Адрес доставки</h5>
							<div class="cabinet-form-div">
								<div class="mt-2 mb-4">
									<div class="label">Город</div>
									<div class="value">Не указано</div>
								</div>
								<div class="row">
									<div class="mt-2 mb-4 col-12 col-lg-7 col-xl-8">
										<div class="label">Улица</div>
										<div class="value">Не указано</div>
									</div>
									<div class="mt-2 mb-4 col-12 col-lg-5 col-xl-4">
										<div class="label">Номер дома</div>
										<div class="value">Не указано</div>
									</div>
								</div>
								<div class="row mb-3">
									<div class="mt-2 mb-4 col-6 col-xl-3">
										<div class="label">Корп.</div>
										<div class="value">Не указано</div>
									</div>
									<div class="mt-2 mb-4 col-6 col-xl-3">
										<div class="label">Под.</div>
										<div class="value">Не указано</div>
									</div>
									<div class="mt-2 mb-4 col-6 col-xl-3">
										<div class="label">Кв./оф.</div>
										<div class="value">Не указано</div>
									</div>
									<div class="mt-2 mb-4 col-6 col-xl-3">
										<div class="label">Этаж</div>
										<div class="value">Не указано</div>
									</div>
								</div>
								<div class="mb-4">
									<a href="#" class="text-secondary font-weight-bold cabinet-form-edit">Изменить адрес доставки</a>
								</div>
							</div>
							<form class="cabinet-form" style="display:none">
								<div class="cabinet-form-textinput">
									<label>
										<span>Город</span>
										<input name="city" type="text" required>
									</label>
								</div>
								<div class="row">
									<div class="cabinet-form-textinput col-12 col-lg-7 col-xl-8">
										<label>
											<span>Улица</span>
											<input name="street" type="mail" required>
										</label>
									</div>
									<div class="cabinet-form-textinput col-12 col-lg-5 col-xl-4">
										<label>
											<span>Номер дома</span>
											<input name="building" type="text" required>
										</label>
									</div>
								</div>
								<div class="row">
									<div class="cabinet-form-textinput col-6 col-xl-3">
										<label>
											<span>Корп.</span>
											<input name="housing" type="text">
										</label>
									</div>
									<div class="cabinet-form-textinput col-6 col-xl-3">
										<label>
											<span>Под.</span>
											<input name="entrance" type="text">
										</label>
									</div>
									<div class="cabinet-form-textinput col-6 col-xl-3">
										<label>
											<span>Кв./оф.</span>
											<input name="apartment" type="text" required>
										</label>
									</div>
									<div class="cabinet-form-textinput col-6 col-xl-3">
										<label>
											<span>Этаж</span>
											<input name="floor" type="text">
										</label>
									</div>
								</div>
								<div class="cabinet-form-submitinput d-flex justify-content-between align-items-center flex-wrap">
									<button class="btn text-secondary cabinet-form-edit">Отменить</button>
									<button class="btn btn-outline-secondary" type="submit">Сохранить</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?// $APPLICATION->IncludeComponent(
// 	"bitrix:sale.personal.section", 
// 	"default", 
// 	array(
// 		"ACCOUNT_PAYMENT_ELIMINATED_PAY_SYSTEMS" => array(
// 			0 => "0",
// 		),
// 		"ACCOUNT_PAYMENT_PERSON_TYPE" => "1",
// 		"ACCOUNT_PAYMENT_SELL_SHOW_FIXED_VALUES" => "Y",
// 		"ACCOUNT_PAYMENT_SELL_TOTAL" => array(
// 			0 => "100",
// 			1 => "200",
// 			2 => "500",
// 			3 => "1000",
// 			4 => "5000",
// 			5 => "",
// 		),
// 		"ACCOUNT_PAYMENT_SELL_USER_INPUT" => "Y",
// 		"ACTIVE_DATE_FORMAT" => "d.m.Y",
// 		"CACHE_GROUPS" => "Y",
// 		"CACHE_TIME" => "3600",
// 		"CACHE_TYPE" => "A",
// 		"CHECK_RIGHTS_PRIVATE" => "N",
// 		"COMPATIBLE_LOCATION_MODE_PROFILE" => "N",
// 		"CUSTOM_PAGES" => "",
// 		"CUSTOM_SELECT_PROPS" => array(
// 		),
// 		"NAV_TEMPLATE" => "",
// 		"ORDER_HISTORIC_STATUSES" => array(
// 			0 => "F",
// 		),
// 		"PATH_TO_BASKET" => "/personal/cart",
// 		"PATH_TO_CATALOG" => "/catalog/",
// 		"PATH_TO_CONTACT" => "/about/contacts",
// 		"PATH_TO_PAYMENT" => "/personal/order/payment/",
// 		"PER_PAGE" => "20",
// 		"PROP_1" => array(
// 		),
// 		"PROP_2" => array(
// 		),
// 		"SAVE_IN_SESSION" => "Y",
// 		"SEF_FOLDER" => "/personal/",
// 		"SEF_MODE" => "Y",
// 		"SEND_INFO_PRIVATE" => "N",
// 		"SET_TITLE" => "Y",
// 		"SHOW_ACCOUNT_COMPONENT" => "Y",
// 		"SHOW_ACCOUNT_PAGE" => "Y",
// 		"SHOW_ACCOUNT_PAY_COMPONENT" => "Y",
// 		"SHOW_BASKET_PAGE" => "Y",
// 		"SHOW_CONTACT_PAGE" => "Y",
// 		"SHOW_ORDER_PAGE" => "Y",
// 		"SHOW_PRIVATE_PAGE" => "Y",
// 		"SHOW_PROFILE_PAGE" => "Y",
// 		"ALLOW_INNER" => "N",
// 		"ONLY_INNER_FULL" => "N",
// 		"SHOW_SUBSCRIBE_PAGE" => "Y",
// 		"USER_PROPERTY_PRIVATE" => "",
// 		"USE_AJAX_LOCATIONS_PROFILE" => "Y",
// 		"COMPONENT_TEMPLATE" => "default",
// 		"ACCOUNT_PAYMENT_SELL_CURRENCY" => "RUB",
// 		"ORDER_HIDE_USER_INFO" => array(
// 			0 => "0",
// 		),
// 		"ORDER_RESTRICT_CHANGE_PAYSYSTEM" => array(
// 			0 => "0",
// 		),
// 		"ORDER_DEFAULT_SORT" => "STATUS",
// 		"ORDER_REFRESH_PRICES" => "N",
// 		"ORDER_DISALLOW_CANCEL" => "N",
// 		"ORDERS_PER_PAGE" => "20",
// 		"PROFILES_PER_PAGE" => "20",
// 		"MAIN_CHAIN_NAME" => "Мой кабинет",
// 		"SEF_URL_TEMPLATES" => array(
// 			"index" => "index.php",
// 			"orders" => "orders/",
// 			"account" => "account/",
// 			"subscribe" => "subscribe/",
// 			"profile" => "profiles/",
// 			"profile_detail" => "profiles/#ID#",
// 			"private" => "private/",
// 			"order_detail" => "orders/#ID#",
// 			"order_cancel" => "cancel/#ID#",
// 		)
// 	),
// 	false
// );

?><br>
	<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>