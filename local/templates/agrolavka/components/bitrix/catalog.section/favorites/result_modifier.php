<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogSectionComponent $component
 */


$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();

if(!$USER->IsAuthorized()) {
	$favorites = unserialize($_COOKIE['BITRIX_SM_favorites']);
 }else {
	  $idUser = $USER->GetID();
	  $rsUser = CUser::GetByID($idUser);
	  $arUser = $rsUser->Fetch();
	  $favorites = $arUser['UF_FAVORITES'];
	 $favorites_cookie = unserialize($_COOKIE['BITRIX_SM_favorites']);
	 if(!empty($favorites_cookie)) {
		 $favorites_cookie = array_map('intval', $favorites_cookie);
		 $favorites = array_merge($favorites, $favorites_cookie);
		 $favorites = array_unique($favorites);
	 }
 }

//  $arItemsIds = [];
//  foreach ($arResult['ITEMS'] as &$arItem) {
//      $arItemsIds[] = $arItem['ID'];
//  }

//$arResult['FAV_IDS'] = $favorites;
//$arResult['ITEMS'] = array_merge($arResult['ITEMS'], $arResult['FAV_IDS']);
//$arResult = array_merge($arResult, $arResult['FAV_IDS']);

//print_r($arResult['FAV_IDS']);

//  $keyName = 'FAV_IDS';
//  if(is_object($this->__component)) {
//     $cp = $this->__component;
//     $cp->arResult[$keyName] = $arItemsIds;
//     $cp->SetResultCacheKeys(array($keyName));

//     if (!isset($arResult[$keyName])) {
//         $arResult[$keyName] = $cp->arResult[$keyName];
//     }
//  }

