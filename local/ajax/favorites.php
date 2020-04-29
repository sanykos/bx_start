<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Application;
use Bitrix\Main\Web\Cookie;
// Избранное для пользователей

// Получаем текущее соединение
$context = Application::getInstance()->getContext();

if((!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) {
    if(isset($_GET['id']) && $_GET['id']) {
        if(!$USER->IsAuthorized()) {
           $arElements = unserialize($context->getRequest()->getCookie('favorites'));
            if(!in_array($_GET['id'], $arElements)){
                $arElements[] = $_GET['id'];
                $result['status'] = 'success';
                $result['fav_status'] = 'added';
                $result['fav_count'] = count($arElements);
                //$result['fav_id'] = $_GET['id'];
            }else {
                $key = array_search($_GET['id'], $arElements);
                unset($arElements[$key]);
                $result['status'] = 'success';
                $result['fav_status'] = 'deleted';
                $result['fav_count'] = count($arElements);
            }
                //setcookie('favorites', serialize($arElements), time() + 3600*24, '/');
                 $cookie = new Cookie('favorites', serialize($arElements), time() + 3600*24);
                 $cookie->setDomain($context->getServer()->getHttpHost());
                 $cookie->setHttpOnly(false);
                // // Если используется не https
                 $cookie->setSecure(false);
                // // Добавляем куки
                 $context->getResponse()->addCookie($cookie);
                // // Обновить заголовки
                $context->getResponse()->flush("");
               //echo json_encode($cookie);
        }else {
            $idUser = $USER->GetID();
            $rsUser = CUser::GetByID($idUser);
            $arUser = $rsUser->Fetch();
            $arElements = $arUser['UF_FAVORITES'];
            $context->getResponse()->flush("");
            $favorites_cookie = unserialize($context->getRequest()->getCookie('favorites'));
           // echo json_encode($favorites_cookie);
            if(!empty($favorites_cookie)){
                $favorites_cookie = array_map('intval', $favorites_cookie);
                $arElements = array_merge($arElements, $favorites_cookie);
                //echo json_encode($arElements);
                $arElements =  array_unique($arElements);
                $cookie = new Cookie('favorites', null, time() - 3600*24);
                $cookie->setHttpOnly(false);
                $cookie->setSecure(false);
                $context->getResponse()->addCookie($cookie);
                $context->getResponse()->flush("");
            }
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
            $USER->Update($idUser, Array("UF_FAVORITES"=>$arElements));
            //echo json_encode($arUser);
        }
    }
  echo json_encode($result);
}