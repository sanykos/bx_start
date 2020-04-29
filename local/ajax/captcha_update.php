<?php 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

include_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/captcha.php");

$cpt = new CCaptcha();
$cpt->Delete($_POST['captcha_sid']);

echo json_encode(htmlspecialchars($APPLICATION->CaptchaGetCode()));
