<?php 
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Application;
global $USER, $APPLICATION;

if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
    if(isset($_GET['id']) && $_GET['id']) {
        if($USER->IsAuthorized()) {
            $idUser = $USER->GetID();
            $rsUser = CUser::GetByID($idUser);
            $arUser = $rsUser->Fetch();
            $arElements = $arUser['UF_BRANDFAV'];
            if(!in_array($_GET['id'], $arElements)) {
                $arElements[] = $_GET['id'];
                $result['status'] = 'success';
                $result['fav_status'] = 'added';
                $result['fav_count'] = count($arElements);
            }else {
                $key = array_search($_GET['id'], $arElements);
                unset($arElements[$key]);
                $result['status'] = 'success';
                $result['fav_status'] = 'deleted';
                $result['fav_count'] = count($arElements);
            }
            $USER->Update($idUser, Array("UF_BRANDFAV"=>$arElements));
        }
    }
    echo json_encode($result);
}