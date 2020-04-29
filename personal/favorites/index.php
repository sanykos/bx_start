<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
global $USER;

use Bitrix\Main\Grid\Declension;
$productDeclension = new Declension('товар', 'товара', 'товаров');

$count_fav = 0;
if(!$USER->IsAuthorized()) {
   $favorites = unserialize($_COOKIE['BITRIX_SM_favorites']);
   if($favorites) {
		$favorites = array_map('intval', $favorites);
		$count_fav = count($favorites);
   }
   
}else {
    $idUser = $USER->GetID();
    $rsUser = CUser::GetByID($idUser);
    $arUser = $rsUser->Fetch();
	$favorites = $arUser['UF_FAVORITES'];
	if(!empty($favorites))
		$count_fav = count($favorites);
	
	$favorites_cookie = unserialize($_COOKIE['BITRIX_SM_favorites']);
	if(!empty($favorites_cookie)) {
		$favorites_cookie = array_map('intval', $favorites_cookie);
    	$favorites = array_merge($favorites, $favorites_cookie);
		$favorites = array_unique($favorites);
		$count_fav = count($favorites);
	}
}

//echo $count_fav;

//help_arr($_SERVER);
?>
<section class="account-section">
	<div class="w-100">
		<div class="row">
		<?if($USER->IsAuthorized()):?>
			<div class="account-menu col-12 col-md-4 col-lg-3">
				<?php echo file_get_contents($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/personal/sect_sidebar.php')?>
			</div>
		<?endif;?>
			<div class="<?=(!$USER->IsAuthorized()) ? 'col-12 col-md-12 col-lg-12': 'col-12 col-md-8 col-lg-9'?>">
				<h5 class="section-title section-title-h5">Избранные товары <sup class="font-weight-normal text-gray"><small><?=$count_fav.' '.$productDeclension->get($count_fav);?> </small></sup></h5>
				
				
				<?// Фильтр для вывода товаров
					if(!empty($favorites)) {
					$GLOBALS['arrFilter'] = Array("ID" => $favorites);?>
					<!-- <div class="card-items-favourite-filters">
						<form action="" class="favourite-filters__sort">
							<select name="" id="">
								<option selected="" value="Самые последние">Недавно добавленные</option>
								<option value="Самые первые">Самые первые</option>
							</select>
						</form>
						<label class="bx-filter-param-label check option">
							<span class="bx-filter-input-checkbox">
								<input class="check__input" type="checkbox">
								<span class="check__box"></span>
								Есть в наличии
							</span>
						</label>
					</div> -->
					<div class="favorites__section">
					<?
					$APPLICATION->IncludeComponent(
	"bitrix:catalog.section", 
	"favorites", 
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "-",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BACKGROUND_IMAGE" => "-",
		"BASKET_URL" => "/personal/card",
		"BROWSER_TITLE" => "-",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "{\"CLASS_ID\":\"CondGroup\",\"DATA\":{\"All\":\"AND\",\"True\":\"True\"},\"CHILDREN\":[]}",
		"DETAIL_URL" => "#SITE_DIR#/catalog/#SECTION_CODE_PATH#/#ELEMENT_CODE#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_COMPARE" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "1C",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
		),
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_BTN_SUBSCRIBE" => "Подписаться",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"OFFERS_LIMIT" => "5",
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_FIELD2" => "id",
		"OFFERS_SORT_ORDER" => "asc",
		"OFFERS_SORT_ORDER2" => "desc",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Товары",
		"PAGE_ELEMENT_COUNT" => "18",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_DISPLAY_MODE" => "N",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SEF_MODE" => "N",
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"SHOW_ALL_WO_SECTION" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"COMPONENT_TEMPLATE" => "favorites"
	),
	false
);
					?>
					</div>
					<?}else{?>
						<section class="reviews-content__empty mb-4">
					<div class="card bg-gray border-0 p-4 border-radius">
						<h6 class="section-title section-title-h6 pt-2 px-2">У вас еще нет избранных товаров</h5>
						<p class="text-gray px-2 mb-4">Исправьте это: перейдите в каталог и добавьте товары в избранное, они сразу же появятся в этом разделе!</p>
						<a class="btn btn-secondary orange-gradient border-0 py-0" href="/catalog/">Каталог</a>
					</div>
				</section>
				<?}?>
			</div>
		</div>
	</div>
</section>







<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>