<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
global $APPLICATION, $USER;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogProductsViewedComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

$this->setFrameMode(true);


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

if (isset($arResult['ITEM']))
{

	//print_r($arResult['ITEM']);
	
$has_query = isset(parse_url($_SERVER['REQUEST_URI'])['query']) && parse_url($_SERVER['REQUEST_URI'])['query'];
$ap = $has_query ? '&' : '?';
$link_to_cart = $arResult['ITEM']['ADD_URL'] ? $arResult['ITEM']['ADD_URL'] :  $arResult['ITEM']['DETAIL_PAGE_URL'].'?action=ADD2BASKET&id='.$arResult['ITEM']['ID'];
//help_arr($_SERVER);
?>
	<div class="catalog-item <?=$_SERVER['REQUEST_URI']==='/personal/favorites/' ? 'col-xl-3 col-lg-3' : 'col-xl-4 col-lg-4'?> col-md-6 col-sm-6 col-xs-12 mb-3" data-item="<?=$arResult['ITEM']['ID'];?>">
	<div class="card card-item" id="<?=$arResult['AREA_ID']?>" data-entity="item">
		<div class="card-body">
			<a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" title="<?=$arResult['ITEM']['NAME']?>" onclick="">
			<img class="catalog-item-img d-block" src="<?=resize_img($arResult["ITEM"]["DETAIL_PICTURE"])?>"></a>
			<div class="card-text">
				<div class="card-title text-overflow-ellipsis"><a href="<?=$arResult['ITEM']['DETAIL_PAGE_URL']?>" class="font-weight-bold" title="<?=$arResult['ITEM']['NAME']?>" onclick=""><?=$arResult['ITEM']['NAME']?></a></div>
				<?if($arResult['ITEM']['BRAND']):?>
				<div class="card-subtitle text-overflow-ellipsis">
				<a href="javascript:void(0)" class="text-gray" title="<?=$arResult['ITEM']['BRAND']['UF_NAME']?>" onclick="">
					<?=$arResult['ITEM']['BRAND']['UF_NAME'];?>
				</a>
				</div>
				<?endif;?>
				<div class="catalog-stats w-100">
					<div class="products-rating">
						<div class="products-rating-stars">
							<?php
								$feed_count = $arResult['ITEM']['PROPERTIES']['FEEDBACK']['VALUE'] ? count($arResult['ITEM']['PROPERTIES']['FEEDBACK']['VALUE']) : 0;
								$rating = $arResult['ITEM']['PROPERTIES']['RATING']['VALUE'];
								// if(!$rating) $rating = 0;
								$width = round($rating/5*100,0);
							?>
							<div class="stars-div" title="<?php if(!$rating){ ?>Нет оценок<?php } else { ?>Средняя оценка <?=$rating?> из 5<?php } ?>">
								<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
								<div class="stars-div-stat green-gradient" style="width:<?=$width?>%"><?php if(!$rating){ ?>Нет оценок<?php } else { ?>Средняя оценка <?=$rating?> из 5<?php } ?></div>
							</div>
						</div>
						<div class="products-rating-feedbacks" title="<?=$feed_count?> <? $number = $feed_count; $after = array('отзыв','отзыва','отзывов'); $cases = array (2, 0, 1, 1, 1, 2); echo $after[ ($number%100>4 && $number%100<20)? 2: $cases[min($number%10, 5)] ]; ?>">
							<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 14" style="enable-background:new 0 0 16 14;" xml:space="preserve"><path d="M13.53,0H2.47C1.11,0,0,1.11,0,2.47v6.06C0,9.89,1.11,11,2.47,11h7.4c0.09,0,0.17,0.03,0.23,0.09L13,14h1l0-2.86c0-0.11,0.08-0.21,0.19-0.24C15.23,10.62,16,9.67,16,8.53V2.47C16,1.11,14.89,0,13.53,0z M15,8.53c0,0.76-1,1.47-1.33,1.46L13,10v2.59l-2.46-2.46C10.46,10.05,10.35,10,10.23,10H2.47C1.66,10,1,9.34,1,8.53V2.47C1,1.66,1.66,1,2.47,1h11.06C14.34,1,15,1.66,15,2.47V8.53z"/><polygon points="13,10 14,10 14,10 13,10 "/></svg>
							<span class="count"><?=$feed_count?><span>
						</div>
					</div>
					<div class="products-availability <?=($arResult['ITEM']['CATALOG_QUANTITY']<=0) ? '' : 'available'; ?>"><?=($arResult['ITEM']['CATALOG_QUANTITY']<=0) ? 'Нет в наличии' : 'Есть в наличии'; ?></div>
				</div>
			</div>
			<div class="catalog-price w-100">
				<?$price = ($arResult['ITEM']['PRICES']['BASE']['VALUE_VAT']) ? $arResult['ITEM']['PRICES']['BASE']['VALUE_VAT'] : $arResult['ITEM']['ITEM_PRICES'][0]['BASE_PRICE']?>
				<div class="products-price font-weight-bold"><?=$price?> <?if($price):?><span class="rub"><i>руб.</i></span><?endif;?>
					<div class="products-availability <?=($arResult['ITEM']['CATALOG_QUANTITY']<=0) ? '' : 'available'; ?>"><?=($arResult['ITEM']['CATALOG_QUANTITY']<=0) ? 'Нет в наличии' : 'Есть в наличии'; ?></div>
				</div>
				<div class="products-btns">
					<div class="products-fav">
						<a class="favor <?=in_array($arResult['ITEM']['ID'], $favorites) ? 'active':'' ?><?php //$APPLICATION->ShowProperty('FAV_BTN_CLASS_'.$arResult['ITEM']['ID']);?>" href="#" title="Добавить в избранное" data-id="<?=$arResult['ITEM']['ID']?>">
						<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 23 20" style="enable-background:new 0 0 23 20;" xml:space="preserve"><path class="transparent" d="M21.1,2.7c-1.1-1.5-2.4-2.2-3.8-2.2h-0.1c-2.7,0-5.3,2.5-5.8,3c-0.4-0.4-3-3-5.7-3H5.6c-1.4,0-2.7,0.7-3.8,2.2 c-1,1.3-1.4,2.7-1,4.4c0.8,4.2,5.8,8.9,10.8,12.2c5.1-3.3,10-8,10.8-12.2C22.6,5.5,22.2,4,21.1,2.7z"/><path d="M21.7,2.4C20.4,0.9,18.9,0,17.2,0c-2.4-0.1-4.6,1.5-5.7,2.5c-1.1-1-3.3-2.6-5.7-2.5C4.1,0,2.6,0.9,1.3,2.4 c-1.2,1.4-1.6,3.1-1.2,5C1,11.9,6.3,16.8,11.5,20c5.2-3.2,10.5-8.1,11.4-12.6C23.2,5.6,22.8,3.9,21.7,2.4z M21.9,7.3 c-0.8,4-5.5,8.5-10.4,11.6C6.7,15.7,1.9,11.3,1.1,7.3c-0.3-1.6,0-3,1-4.2C3.2,1.7,4.5,1,5.8,1h0.1c2.6,0,5.1,2.4,5.5,2.8l0,0l0,0 C11.9,3.4,14.4,1,17,1h0.1c1.4,0,2.6,0.7,3.7,2.1C21.8,4.3,22.2,5.7,21.9,7.3z"/></svg>
						</a>
					</div>
					<?if($price && $arResult['ITEM']['CATALOG_QUANTITY'] > 0):?>
					<div class="products-cart">
						<a class="btn btn-secondary orange-gradient" data-productname="<?=$arResult['ITEM']['NAME']?>" data-action="add2basket" href="<?=$link_to_cart?>" title="<?=$arParams['MESS_BTN_BUY']?>" onclick="">
							<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M6.7,20c-1.4,0-2.6-1.2-2.6-2.6s1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6S8.2,20,6.7,20z M6.7,15.8c-0.9,0-1.6,0.7-1.6,1.6S5.9,19,6.7,19s1.6-0.7,1.6-1.6S7.6,15.8,6.7,15.8z"/></g><g><path d="M15.7,20c-1.4,0-2.6-1.2-2.6-2.6s1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6S17.1,20,15.7,20z M15.7,15.8c-0.9,0-1.6,0.7-1.6,1.6s0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6S16.5,15.8,15.7,15.8z"/></g><g><path d="M6.9,14c-0.7,0-1.3-0.1-1.6-0.2c-1.4-0.7-2.5-4.2-2.1-9.4C3.1,4,2.5,0.9,0.1,1L0,0c2.5-0.1,3.8,2.4,4.2,3.9h15.2l0.1,0.3c0,0.1,2.4,5.9-3.2,8.3C14.9,13.1,9.7,14,6.9,14z M4.2,5c-0.3,5,0.9,7.6,1.6,8c0.8,0.4,8.2-0.5,10.1-1.3C20,9.9,19,6.1,18.7,5H4.2z"/></g></svg>
						</a>
					</div>
					<?elseif(!$price):?>
						<div style="margin-left: 10px"><strong>Цена по запросу</strong></div>
					<?endif;?>
				</div>
			</div>
		</div>
	</div>
	</div>
<?
}