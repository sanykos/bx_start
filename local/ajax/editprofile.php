<?php 
// Редактирование профиля.

// Если инициализировать данную константу каким либо значением, то это запретит сбор статистики на данной странице.
define("NO_KEEP_STATISTIC", true);
//Если инициализировать данную константу значением "true" до подключения пролога, то это отключит проверку прав на доступ к файлам и каталогам.
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

global $APPLICATION, $USER, $DB;

if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
    if($USER->IsAuthorized()) {

        $arFields = [];

        $idUser = $USER->GetID();

        if($_POST['name'] != '') {
            $arFields['NAME'] = strip_tags($_POST['name']);
        }
        if($_POST['last_name'] != '') {
            $arFields['LAST_NAME'] = strip_tags($_POST['last_name']);
        }
        if($_POST['second_name'] != '') {
            $arFields['SECOND_NAME'] = strip_tags($_POST['second_name']);
        }

        if($_POST['email'] != '') {
            $arFields['EMAIL'] = strip_tags($_POST['email']);
        }

        if($_POST['phone'] != '') {
            $arFields['PERSONAL_PHONE'] = strip_tags($_POST['phone']);
        }

        if($_POST['birthday'] != '') {
            $arFields['PERSONAL_BIRTHDAY'] = strip_tags($_POST['birthday']);
        }

        if(isset($_POST['sex'])) {
            $arFields['PERSONAL_GENDER'] = strip_tags($_POST['sex']);
        }
        
        //echo json_encode($_POST);

        if(!empty($arFields)) {
            $USER->Update($idUser, $arFields);
            echo json_encode($arFields);
        }
    }
    //print_r(json_encode($_POST));
    
    

}

?>