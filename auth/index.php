<?
//define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
global $USER;
?>

<?if($USER->isAuthorized()) LocalRedirect("/personal/");


if($_REQUEST['change_password'] == 'yes'):

$APPLICATION->IncludeComponent(
	"bitrix:main.auth.changepasswd",
	"default",
	Array(
		"AUTH_AUTH_URL" => "/auth/",
		"AUTH_REGISTER_URL" => "/auth/registration.php"
	)
);

else:
 $APPLICATION->IncludeComponent("bitrix:system.auth.form", "default", Array(
		"FORGOT_PASSWORD_URL" => "/auth/forget.php",	// Страница забытого пароля
		"PROFILE_URL" => "/personal/",	// Страница профиля
		"REGISTER_URL" => "/auth/registration.php",	// Страница регистрации
		"SHOW_ERRORS" => "Y",	// Показывать ошибки
	),
	false
);
endif;
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");