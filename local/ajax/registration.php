<?php 
// Если инициализировать данную константу каким либо значением, то это запретит сбор статистики на данной странице.
define("NO_KEEP_STATISTIC", true);
//Если инициализировать данную константу значением "true" до подключения пролога, то это отключит проверку прав на доступ к файлам и каталогам.
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

global $APPLICATION, $USER, $DB;

if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
    //echo json_encode($_POST);
    if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_confirm'])) {
        if(($APPLICATION->CaptchaCheckCode($_POST["captcha_word"], $_POST["captcha_sid"]))) {
             
			$email = strip_tags($_POST['email']);
			$password = strip_tags($_POST['password']);
			$password_confirm = strip_tags($_POST['password_confirm']);
		
            $bConfirmReq = (COption::GetOptionString("main", "new_user_registration_email_confirmation", "N")) == "Y";
            
            $arFields = Array(
                "EMAIL"             => $email,
                "LOGIN"             => $email,
                "LID"               => SITE_ID,
                "ACTIVE"            => "Y",
                "GROUP_ID"          => array(2),
                "PASSWORD"          => $password,
                "CONFIRM_PASSWORD"  => $password_confirm,
                "CHECKWORD" => md5(CMain::GetServerUniqID().uniqid()),
                "~CHECKWORD_TIME" => $DB->CurrentTimeFunction(),
                "CONFIRM_CODE" =>$bConfirmReq ? randString(8): ""
              );

              $CUser = new CUser;
              $USER_ID = $CUser->Add($arFields);
              if (intval($USER_ID) > 0) {
                $result['status'] = 'success';
                $result['message'] = 'Вы успешно зарегистрировались, Вам отправлено письмо для потверждения';
                
                $arFields['USER_ID'] = $USER_ID;
                
                $arEventFields = $arFields;				
                
                $event = new CEvent;					
                if($bConfirmReq){
                    $event->SendImmediate("NEW_USER_CONFIRM", SITE_ID, $arEventFields);
                }else{
                    $event->SendImmediate("USER_INFO", SITE_ID, $arEventFields);
                }
                // Отправляем Оповешение администратору	
                $event->SendImmediate("NEW_USER", SITE_ID, $arEventFields);
            }else{
                $result['status'] = 'error';
                $result['message'] = html_entity_decode($CUser->LAST_ERROR);
            }	
        } else {
            $result['status'] = 'error';
			$result['message'] = 'Не правильный код картинки';
        }
    }else {
        $result['status'] = 'error';
        $result['message'] = 'Все поля обязательны для заполнения'; 
    }
    echo json_encode($result);
}