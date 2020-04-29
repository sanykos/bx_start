<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

/**
 * @global CMain $APPLICATION
 * @var CBitrixComponent $component
 * @var array $arParams
 * @var array $arResult
 * @var array $arCurSection
 */
 
 ?>
 <?php

if (isset($arParams['USE_COMMON_SETTINGS_BASKET_POPUP']) && $arParams['USE_COMMON_SETTINGS_BASKET_POPUP'] == 'Y')
{
	$basketAction = isset($arParams['COMMON_ADD_TO_BASKET_ACTION']) ? $arParams['COMMON_ADD_TO_BASKET_ACTION'] : '';
}
else
{
	$basketAction = isset($arParams['SECTION_ADD_TO_BASKET_ACTION']) ? $arParams['SECTION_ADD_TO_BASKET_ACTION'] : '';
}

if ($isFilter || $isSidebar): ?>
	<div class="col-md-3 col-sm-4 col-sm-push-8 col-md-push-9<?=(isset($arParams['FILTER_HIDE_ON_MOBILE']) && $arParams['FILTER_HIDE_ON_MOBILE'] === 'Y' ? ' hidden-xs' : '')?>">
		<? if ($isFilter): ?>
			<div class="bx-sidebar-block">
				<?
				$APPLICATION->IncludeComponent(
					"bitrix:catalog.smart.filter",
					"",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"SECTION_ID" => $arCurSection['ID'],
						"FILTER_NAME" => $arParams["FILTER_NAME"],
						"PRICE_CODE" => $arParams["~PRICE_CODE"],
						"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						"CACHE_TIME" => $arParams["CACHE_TIME"],
						"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						"SAVE_IN_SESSION" => "N",
						"FILTER_VIEW_MODE" => $arParams["FILTER_VIEW_MODE"],
						"XML_EXPORT" => "N",
						"SECTION_TITLE" => "NAME",
						"SECTION_DESCRIPTION" => "DESCRIPTION",
						'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
						"TEMPLATE_THEME" => $arParams["TEMPLATE_THEME"],
						'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						"SEF_MODE" => $arParams["SEF_MODE"],
						"SEF_RULE" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["smart_filter"],
						"SMART_FILTER_PATH" => $arResult["VARIABLES"]["SMART_FILTER_PATH"],
						"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
						"INSTANT_RELOAD" => $arParams["INSTANT_RELOAD"],
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);
				?>
			</div>
		<? endif ?>
		<? if ($isSidebar): ?>
			<div class="hidden-xs">
				<?
				$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"PATH" => $arParams["SIDEBAR_PATH"],
						"AREA_FILE_RECURSIVE" => "N",
						"EDIT_MODE" => "html",
					),
					false,
					array('HIDE_ICONS' => 'Y')
				);
				?>
			</div>
		<?endif?>
	</div>
<?endif?>
<div class="<?=(($isFilter || $isSidebar) ? "col-md-9 col-sm-8 col-sm-pull-4 col-md-pull-3" : "col-xs-12")?>">
	<div class="row">
		<div class="col-xs-12">
			<?
			if (ModuleManager::isModuleInstalled("sale"))
			{
				$arRecomData = array();
				$recomCacheID = array('IBLOCK_ID' => $arParams['IBLOCK_ID']);
				$obCache = new CPHPCache();
				if ($obCache->InitCache(36000, serialize($recomCacheID), "/sale/bestsellers"))
				{
					$arRecomData = $obCache->GetVars();
				}
				elseif ($obCache->StartDataCache())
				{
					if (Loader::includeModule("catalog"))
					{
						$arSKU = CCatalogSku::GetInfoByProductIBlock($arParams['IBLOCK_ID']);
						$arRecomData['OFFER_IBLOCK_ID'] = (!empty($arSKU) ? $arSKU['IBLOCK_ID'] : 0);
					}
					$obCache->EndDataCache($arRecomData);
				}

				if (!empty($arRecomData) && $arParams['USE_GIFTS_SECTION'] === 'Y')
				{
					?>
					<div data-entity="parent-container">
						<?
						if (!isset($arParams['GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE']) || $arParams['GIFTS_SECTION_LIST_HIDE_BLOCK_TITLE'] !== 'Y')
						{
							?>
							<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
								<?=($arParams['GIFTS_SECTION_LIST_BLOCK_TITLE'] ?: \Bitrix\Main\Localization\Loc::getMessage('CT_GIFTS_SECTION_LIST_BLOCK_TITLE_DEFAULT'))?>
							</div>
							<?
						}
						
						// gift
						//CBitrixComponent::includeComponentClass('bitrix:sale.products.gift.section');
						?>
					</div>
					<?
				}
			}
			?>
		</div>
		<div class="w-100">
			<?
			$APPLICATION->IncludeComponent(
				"bitrix:catalog.section.list",
				"",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"DEPTH_LEVEL" => isset($DEPTH_LEVEL) ? $DEPTH_LEVEL : 0,
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
					"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
					"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
					"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
					"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
					"ADD_SECTIONS_CHAIN" => (isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
				),
				$component,
				array("HIDE_ICONS" => "Y")
			);

			if ($arParams["USE_COMPARE"]=="Y")
			{
				$APPLICATION->IncludeComponent(
					"bitrix:catalog.compare.list",
					"",
					array(
						"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						"NAME" => $arParams["COMPARE_NAME"],
						"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						"COMPARE_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["compare"],
						"ACTION_VARIABLE" => (!empty($arParams["ACTION_VARIABLE"]) ? $arParams["ACTION_VARIABLE"] : "action"),
						"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						'POSITION_FIXED' => isset($arParams['COMPARE_POSITION_FIXED']) ? $arParams['COMPARE_POSITION_FIXED'] : '',
						'POSITION' => isset($arParams['COMPARE_POSITION']) ? $arParams['COMPARE_POSITION'] : ''
					),
					$component,
					array("HIDE_ICONS" => "Y")
				);
			}
			?>
				<?
				if ($_GET["sort"] == "price") {
					//PRICE_TYPE - объявлена в init.php
					$arParams["ELEMENT_SORT_FIELD"] = PRICE_TYPE;
				}
				if ($_GET["order"] == "asc") $arParams["ELEMENT_SORT_ORDER"]= "asc";
				if ($_GET["order"] == "desc") $arParams["ELEMENT_SORT_ORDER"]= "desc";
				$ap = strpos($_SERVER['REQUEST_URI'], '/?') ? '&' : '?';
				$url = parse_url($_SERVER['REQUEST_URI']);
				parse_str($url['query'], $query);
				$query['order'] = 'asc';
				$url_asc = $url['path'].'?'.http_build_query(array_merge($query, ['order' => 'asc', 'sort' => 'price']));
				$url_desc = $url['path'].'?'.http_build_query(array_merge($query, ['order' => 'desc', 'sort' => 'price']));
				$onclick_asc = "BX.ajax.insertToNode('$url_asc', '".$arParams['AJAX_ID']."');  return false;";
				$onclick_desc = "BX.ajax.insertToNode('$url_desc', '".$arParams['AJAX_ID']."');  return false;";
				?>
				<script>
					$(function() {
						// $('.sort-price').on('click', 'a', function() {
						// 	//console.log(this);
						// 	return false;
						// })
						//console.log('run');
					});
				</script>
				<div class="sort-price">
					<div class="col-12 mb-2">
						<div class="row">
							<div class="col mb-2">
								<a data-sort="asc" class="active" href="<?=$url_asc?>" <?=$onclick_asc?>>по возрастанию</a> |
								<a data-sort="desc" href="<?=$url_desc?>" <?=$onclick_desc?>>по убыванию</a>
							</div>
							<div class="col-auto sort-price__view mx-n2 mb-2">
								<a href="#" title="Сетка" class="mx-2 active" >
									<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M2.6,5.2C1.2,5.2,0,4,0,2.6C0,1.2,1.2,0,2.6,0s2.6,1.2,2.6,2.6C5.2,4,4,5.2,2.6,5.2z M2.6,1C1.7,1,1,1.7,1,2.6 c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C4.2,1.7,3.5,1,2.6,1z"/></g><g><path d="M10,5.2C8.6,5.2,7.4,4,7.4,2.6C7.4,1.2,8.6,0,10,0s2.6,1.2,2.6,2.6C12.6,4,11.4,5.2,10,5.2z M10,1C9.1,1,8.4,1.7,8.4,2.6 c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C11.6,1.7,10.9,1,10,1z"/></g><g><path d="M17.4,5.2c-1.4,0-2.6-1.2-2.6-2.6C14.8,1.2,16,0,17.4,0S20,1.2,20,2.6C20,4,18.8,5.2,17.4,5.2z M17.4,1 c-0.9,0-1.6,0.7-1.6,1.6c0,0.9,0.7,1.6,1.6,1.6S19,3.5,19,2.6C19,1.7,18.3,1,17.4,1z"/></g><g><path d="M2.6,12.6C1.2,12.6,0,11.4,0,10c0-1.4,1.2-2.6,2.6-2.6S5.2,8.6,5.2,10C5.2,11.4,4,12.6,2.6,12.6z M2.6,8.4 C1.7,8.4,1,9.1,1,10c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C4.2,9.1,3.5,8.4,2.6,8.4z"/></g><g><path d="M10,12.6c-1.4,0-2.6-1.2-2.6-2.6c0-1.4,1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6C12.6,11.4,11.4,12.6,10,12.6z M10,8.4 c-0.9,0-1.6,0.7-1.6,1.6c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C11.6,9.1,10.9,8.4,10,8.4z"/></g><g><path d="M17.4,12.6c-1.4,0-2.6-1.2-2.6-2.6c0-1.4,1.2-2.6,2.6-2.6S20,8.6,20,10C20,11.4,18.8,12.6,17.4,12.6z M17.4,8.4 c-0.9,0-1.6,0.7-1.6,1.6c0,0.9,0.7,1.6,1.6,1.6S19,10.9,19,10C19,9.1,18.3,8.4,17.4,8.4z"/></g><g><path d="M2.6,20C1.2,20,0,18.8,0,17.4c0-1.4,1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6C5.2,18.8,4,20,2.6,20z M2.6,15.8 c-0.9,0-1.6,0.7-1.6,1.6C1,18.2,1.7,19,2.6,19s1.6-0.7,1.6-1.6C4.2,16.5,3.5,15.8,2.6,15.8z"/></g><g><path d="M10,20c-1.4,0-2.6-1.2-2.6-2.6c0-1.4,1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6C12.6,18.8,11.4,20,10,20z M10,15.8 c-0.9,0-1.6,0.7-1.6,1.6c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C11.6,16.5,10.9,15.8,10,15.8z"/></g><g><path d="M17.4,20c-1.4,0-2.6-1.2-2.6-2.6c0-1.4,1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6C20,18.8,18.8,20,17.4,20z M17.4,15.8 c-0.9,0-1.6,0.7-1.6,1.6c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C19,16.5,18.3,15.8,17.4,15.8z"/></g></svg>
								</a>
								<a href="#" title="Список" class="mx-2 ">
									<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M2.6,5.2C1.2,5.2,0,4,0,2.6C0,1.2,1.2,0,2.6,0s2.6,1.2,2.6,2.6C5.2,4,4,5.2,2.6,5.2z M2.6,1C1.7,1,1,1.7,1,2.6	c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C4.2,1.7,3.5,1,2.6,1z"/></g><g><path d="M2.6,12.6C1.2,12.6,0,11.4,0,10c0-1.4,1.2-2.6,2.6-2.6S5.2,8.6,5.2,10C5.2,11.4,4,12.6,2.6,12.6z M2.6,8.4	C1.7,8.4,1,9.1,1,10c0,0.9,0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6C4.2,9.1,3.5,8.4,2.6,8.4z"/></g><g><path d="M2.6,20C1.2,20,0,18.8,0,17.4c0-1.4,1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6C5.2,18.8,4,20,2.6,20z M2.6,15.8	c-0.9,0-1.6,0.7-1.6,1.6C1,18.2,1.7,19,2.6,19s1.6-0.7,1.6-1.6C4.2,16.5,3.5,15.8,2.6,15.8z"/></g><path d="M17.4,0H10C8.6,0,7.4,1.2,7.4,2.6C7.4,4,8.6,5.2,10,5.2h7.4C18.8,5.2,20,4,20,2.6C20,1.2,18.8,0,17.4,0z M17.4,4.2H10c-0.9,0-1.6-0.7-1.6-1.6C8.4,1.7,9.1,1,10,1h7.4C18.3,1,19,1.7,19,2.6C19,3.5,18.3,4.2,17.4,4.2z"/><path d="M17.4,7.4H10c-1.4,0-2.6,1.2-2.6,2.6c0,1.4,1.2,2.6,2.6,2.6h7.4c1.4,0,2.6-1.2,2.6-2.6C20,8.6,18.8,7.4,17.4,7.4z M17.4,11.6H10c-0.9,0-1.6-0.7-1.6-1.6c0-0.9,0.7-1.6,1.6-1.6h7.4c0.9,0,1.6,0.7,1.6,1.6C19,10.9,18.3,11.6,17.4,11.6z"/><path d="M17.4,14.8H10c-1.4,0-2.6,1.2-2.6,2.6c0,1.4,1.2,2.6,2.6,2.6h7.4c1.4,0,2.6-1.2,2.6-2.6C20,15.9,18.8,14.8,17.4,14.8z M17.4,19H10c-0.9,0-1.6-0.7-1.6-1.6c0-0.9,0.7-1.6,1.6-1.6h7.4c0.9,0,1.6,0.7,1.6,1.6C19,18.2,18.3,19,17.4,19z"/></svg>
								</a>
							</div>
						</div>
					</div>
				</div>

				<script>
					
				</script>
				<?/*
				<select onchange="BX.ajax.insertToNode('/catalog/kormlenie_zhivotnykh/zernovye/filter/cml2_manufacturer-is-c2b5e957-3cdc-11ea-8b1c-1c872c611f89-or-c70dd681-3d1b-11ea-8b1c-1c872c611f89-or-ad10b910-1da7-11ea-8b1c-1c872c611f89/apply/?order=asc&sort=price', '<?='comp_'.$arParams['AJAX_ID']?>'); return false;">
					<option value="<?=$url_asc?>">по возр</option>
					<option value="<?=$url_desc?>">по убыв</option>
				</select>*/
				?>
			<? $intSectionID = $APPLICATION->IncludeComponent(
				"bitrix:catalog.section",
				"",
				array(
					"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
					"IBLOCK_ID" => $arParams["IBLOCK_ID"],
					"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
					"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
					"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
					"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
					"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
					"PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
					"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
					"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
					"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
					"SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
					"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
					"BASKET_URL" => $arParams["BASKET_URL"],
					"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
					"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
					"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
					"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
					"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
					"FILTER_NAME" => $arParams["FILTER_NAME"],
					"CACHE_TYPE" => $arParams["CACHE_TYPE"],
					"CACHE_TIME" => $arParams["CACHE_TIME"],
					"CACHE_FILTER" => $arParams["CACHE_FILTER"],
					"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
					"SET_TITLE" => $arParams["SET_TITLE"],
					"MESSAGE_404" => $arParams["~MESSAGE_404"],
					"SET_STATUS_404" => $arParams["SET_STATUS_404"],
					"SHOW_404" => $arParams["SHOW_404"],
					"FILE_404" => $arParams["FILE_404"],
					"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
					"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
					"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
					"PRICE_CODE" => $arParams["~PRICE_CODE"],
					"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
					"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

					"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
					"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
					"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
					"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
					"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

					"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
					"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
					"PAGER_TITLE" => $arParams["PAGER_TITLE"],
					"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
					"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
					"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
					"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
					"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
					"PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
					"PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
					"PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
					"LAZY_LOAD" => $arParams["LAZY_LOAD"],
					"MESS_BTN_LAZY_LOAD" => $arParams["~MESS_BTN_LAZY_LOAD"],
					"LOAD_ON_SCROLL" => $arParams["LOAD_ON_SCROLL"],

					"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
					"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
					"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
					"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
					"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
					"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
					"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
					"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

					"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
					"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
					"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
					"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
					"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
					'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
					'CURRENCY_ID' => $arParams['CURRENCY_ID'],
					'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
					'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

					'LABEL_PROP' => $arParams['LABEL_PROP'],
					'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
					'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
					'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
					'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
					'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
					'PRODUCT_ROW_VARIANTS' => $arParams['LIST_PRODUCT_ROW_VARIANTS'],
					'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
					'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
					'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
					'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
					'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

					'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
					'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
					'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
					'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
					'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
					'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
					'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
					'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
					'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
					'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
					'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
					'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
					'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
					'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
					'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
					'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
					'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

					'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
					'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
					'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

					'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
					"ADD_SECTIONS_CHAIN" => "N",
					'ADD_TO_BASKET_ACTION' => $basketAction,
					'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
					'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
					'COMPARE_NAME' => $arParams['COMPARE_NAME'],
					'USE_COMPARE_LIST' => 'Y',
					'BACKGROUND_IMAGE' => (isset($arParams['SECTION_BACKGROUND_IMAGE']) ? $arParams['SECTION_BACKGROUND_IMAGE'] : ''),
					'COMPATIBLE_MODE' => (isset($arParams['COMPATIBLE_MODE']) ? $arParams['COMPATIBLE_MODE'] : ''),
					'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
				),
				$component
			);
			?>
		</div>
		<?
		$GLOBALS['CATALOG_CURRENT_SECTION_ID'] = $intSectionID;

		if (ModuleManager::isModuleInstalled("sale"))
		{
			if (!empty($arRecomData))
			{
				if (!isset($arParams['USE_BIG_DATA']) || $arParams['USE_BIG_DATA'] != 'N')
				{
					?>
					<div class="col-xs-12" data-entity="parent-container">
						<div class="catalog-block-header" data-entity="header" data-showed="false" style="display: none; opacity: 0;">
							<?=GetMessage('CATALOG_PERSONAL_RECOM')?>
						</div>
						<?
						// $APPLICATION->IncludeComponent(
						// 	"bitrix:catalog.section",
						// 	"1",
						// 	array(
						// 		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
						// 		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
						// 		"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
						// 		"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
						// 		"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
						// 		"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
						// 		"PROPERTY_CODE" => (isset($arParams["LIST_PROPERTY_CODE"]) ? $arParams["LIST_PROPERTY_CODE"] : []),
						// 		"PROPERTY_CODE_MOBILE" => $arParams["LIST_PROPERTY_CODE_MOBILE"],
						// 		"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
						// 		"BASKET_URL" => $arParams["BASKET_URL"],
						// 		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
						// 		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
						// 		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
						// 		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
						// 		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
						// 		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
						// 		"CACHE_TIME" => $arParams["CACHE_TIME"],
						// 		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
						// 		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
						// 		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
						// 		"PAGE_ELEMENT_COUNT" => 0,
						// 		"PRICE_CODE" => $arParams["~PRICE_CODE"],
						// 		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
						// 		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

						// 		"SET_BROWSER_TITLE" => "N",
						// 		"SET_META_KEYWORDS" => "N",
						// 		"SET_META_DESCRIPTION" => "N",
						// 		"SET_LAST_MODIFIED" => "N",
						// 		"ADD_SECTIONS_CHAIN" => "N",

						// 		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
						// 		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
						// 		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
						// 		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
						// 		"PRODUCT_PROPERTIES" => (isset($arParams["PRODUCT_PROPERTIES"]) ? $arParams["PRODUCT_PROPERTIES"] : []),

						// 		"OFFERS_CART_PROPERTIES" => (isset($arParams["OFFERS_CART_PROPERTIES"]) ? $arParams["OFFERS_CART_PROPERTIES"] : []),
						// 		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
						// 		"OFFERS_PROPERTY_CODE" => (isset($arParams["LIST_OFFERS_PROPERTY_CODE"]) ? $arParams["LIST_OFFERS_PROPERTY_CODE"] : []),
						// 		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
						// 		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
						// 		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
						// 		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
						// 		"OFFERS_LIMIT" => (isset($arParams["LIST_OFFERS_LIMIT"]) ? $arParams["LIST_OFFERS_LIMIT"] : 0),

						// 		"SECTION_ID" => $intSectionID,
						// 		"SECTION_CODE" => "",
						// 		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
						// 		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
						// 		"USE_MAIN_ELEMENT_SECTION" => $arParams["USE_MAIN_ELEMENT_SECTION"],
						// 		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
						// 		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
						// 		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],
						// 		'HIDE_NOT_AVAILABLE_OFFERS' => $arParams["HIDE_NOT_AVAILABLE_OFFERS"],

						// 		'LABEL_PROP' => $arParams['LABEL_PROP'],
						// 		'LABEL_PROP_MOBILE' => $arParams['LABEL_PROP_MOBILE'],
						// 		'LABEL_PROP_POSITION' => $arParams['LABEL_PROP_POSITION'],
						// 		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
						// 		'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
						// 		'PRODUCT_BLOCKS_ORDER' => $arParams['LIST_PRODUCT_BLOCKS_ORDER'],
						// 		'PRODUCT_ROW_VARIANTS' => "[{'VARIANT':'3','BIG_DATA':true}]",
						// 		'ENLARGE_PRODUCT' => $arParams['LIST_ENLARGE_PRODUCT'],
						// 		'ENLARGE_PROP' => isset($arParams['LIST_ENLARGE_PROP']) ? $arParams['LIST_ENLARGE_PROP'] : '',
						// 		'SHOW_SLIDER' => $arParams['LIST_SHOW_SLIDER'],
						// 		'SLIDER_INTERVAL' => isset($arParams['LIST_SLIDER_INTERVAL']) ? $arParams['LIST_SLIDER_INTERVAL'] : '',
						// 		'SLIDER_PROGRESS' => isset($arParams['LIST_SLIDER_PROGRESS']) ? $arParams['LIST_SLIDER_PROGRESS'] : '',

						// 		"DISPLAY_TOP_PAGER" => 'N',
						// 		"DISPLAY_BOTTOM_PAGER" => 'N',
						// 		"HIDE_SECTION_DESCRIPTION" => "Y",

						// 		"RCM_TYPE" => isset($arParams['BIG_DATA_RCM_TYPE']) ? $arParams['BIG_DATA_RCM_TYPE'] : '',
						// 		"SHOW_FROM_SECTION" => 'Y',

						// 		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
						// 		'OFFER_TREE_PROPS' => (isset($arParams['OFFER_TREE_PROPS']) ? $arParams['OFFER_TREE_PROPS'] : []),
						// 		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
						// 		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
						// 		'DISCOUNT_PERCENT_POSITION' => $arParams['DISCOUNT_PERCENT_POSITION'],
						// 		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
						// 		'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
						// 		'MESS_SHOW_MAX_QUANTITY' => (isset($arParams['~MESS_SHOW_MAX_QUANTITY']) ? $arParams['~MESS_SHOW_MAX_QUANTITY'] : ''),
						// 		'RELATIVE_QUANTITY_FACTOR' => (isset($arParams['RELATIVE_QUANTITY_FACTOR']) ? $arParams['RELATIVE_QUANTITY_FACTOR'] : ''),
						// 		'MESS_RELATIVE_QUANTITY_MANY' => (isset($arParams['~MESS_RELATIVE_QUANTITY_MANY']) ? $arParams['~MESS_RELATIVE_QUANTITY_MANY'] : ''),
						// 		'MESS_RELATIVE_QUANTITY_FEW' => (isset($arParams['~MESS_RELATIVE_QUANTITY_FEW']) ? $arParams['~MESS_RELATIVE_QUANTITY_FEW'] : ''),
						// 		'MESS_BTN_BUY' => (isset($arParams['~MESS_BTN_BUY']) ? $arParams['~MESS_BTN_BUY'] : ''),
						// 		'MESS_BTN_ADD_TO_BASKET' => (isset($arParams['~MESS_BTN_ADD_TO_BASKET']) ? $arParams['~MESS_BTN_ADD_TO_BASKET'] : ''),
						// 		'MESS_BTN_SUBSCRIBE' => (isset($arParams['~MESS_BTN_SUBSCRIBE']) ? $arParams['~MESS_BTN_SUBSCRIBE'] : ''),
						// 		'MESS_BTN_DETAIL' => (isset($arParams['~MESS_BTN_DETAIL']) ? $arParams['~MESS_BTN_DETAIL'] : ''),
						// 		'MESS_NOT_AVAILABLE' => (isset($arParams['~MESS_NOT_AVAILABLE']) ? $arParams['~MESS_NOT_AVAILABLE'] : ''),
						// 		'MESS_BTN_COMPARE' => (isset($arParams['~MESS_BTN_COMPARE']) ? $arParams['~MESS_BTN_COMPARE'] : ''),

						// 		'USE_ENHANCED_ECOMMERCE' => (isset($arParams['USE_ENHANCED_ECOMMERCE']) ? $arParams['USE_ENHANCED_ECOMMERCE'] : ''),
						// 		'DATA_LAYER_NAME' => (isset($arParams['DATA_LAYER_NAME']) ? $arParams['DATA_LAYER_NAME'] : ''),
						// 		'BRAND_PROPERTY' => (isset($arParams['BRAND_PROPERTY']) ? $arParams['BRAND_PROPERTY'] : ''),

						// 		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
						// 		'ADD_TO_BASKET_ACTION' => $basketAction,
						// 		'SHOW_CLOSE_POPUP' => isset($arParams['COMMON_SHOW_CLOSE_POPUP']) ? $arParams['COMMON_SHOW_CLOSE_POPUP'] : '',
						// 		'COMPARE_PATH' => $arResult['FOLDER'].$arResult['URL_TEMPLATES']['compare'],
						// 		'COMPARE_NAME' => $arParams['COMPARE_NAME'],
						// 		'USE_COMPARE_LIST' => 'Y',
						// 		'BACKGROUND_IMAGE' => '',
						// 		'DISABLE_INIT_JS_IN_COMPONENT' => (isset($arParams['DISABLE_INIT_JS_IN_COMPONENT']) ? $arParams['DISABLE_INIT_JS_IN_COMPONENT'] : '')
						// 	),
						// 	$component
						// );
						?>
					</div>
					<?
				}
			}
		}
		?>
	</div>
</div>