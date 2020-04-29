<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;

$this->setFrameMode(true);?>
<?

if (!isset($arParams['FILTER_VIEW_MODE']) || (string)$arParams['FILTER_VIEW_MODE'] == '')
	$arParams['FILTER_VIEW_MODE'] = 'VERTICAL';
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');

$isVerticalFilter = ('Y' == $arParams['USE_FILTER'] && $arParams["FILTER_VIEW_MODE"] == "VERTICAL");
$isSidebar = ($arParams["SIDEBAR_SECTION_SHOW"] == "Y" && isset($arParams["SIDEBAR_PATH"]) && !empty($arParams["SIDEBAR_PATH"]));
$isSidebarLeft = isset($arParams['SIDEBAR_SECTION_POSITION']) && $arParams['SIDEBAR_SECTION_POSITION'] === 'left';
$isFilter = ($arParams['USE_FILTER'] == 'Y');
$DEPTH_LEVEL = 0;

if ($isFilter)
{
	$arFilter = array(
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ACTIVE" => "Y",
		"GLOBAL_ACTIVE" => "Y",
	);
	if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
		$arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
	elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
		$arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];

	$obCache = new CPHPCache();
	if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog"))
	{
		$arCurSection = $obCache->GetVars();
		$DEPTH_LEVEL = $arCurSection['DEPTH_LEVEL'];
	}
	elseif ($obCache->StartDataCache())
	{
		$arCurSection = array();
		if (Loader::includeModule("iblock"))
		{
			$dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID", "DEPTH_LEVEL"));

			//print_r($dbRes);

			if(defined("BX_COMP_MANAGED_CACHE"))
			{
				global $CACHE_MANAGER;
				$CACHE_MANAGER->StartTagCache("/iblock/catalog");

				if ($arCurSection = $dbRes->Fetch())
					$CACHE_MANAGER->RegisterTag("iblock_id_".$arParams["IBLOCK_ID"]);
					$DEPTH_LEVEL = $arCurSection['DEPTH_LEVEL'];
					//print_r($arCurSection);

				$CACHE_MANAGER->EndTagCache();
			}
			else
			{
				if(!$arCurSection = $dbRes->Fetch())
					$arCurSection = array();
			}
		}
		$obCache->EndDataCache($arCurSection);
	}
	if (!isset($arCurSection))
		$arCurSection = array();
}



if ($DEPTH_LEVEL && $DEPTH_LEVEL < 2) {
include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/sub_section.php");
}
else { ?>

<?php 

$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"topsectionlist",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_USER_FIELDS" => array("UF_BACKGROUND_IMAGE"),
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
		"TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"]) ? $arParams["SECTIONS_HIDE_SECTION_NAME"] : "N"),
		"ADD_SECTIONS_CHAIN" => "N"//(isset($arParams["ADD_SECTIONS_CHAIN"]) ? $arParams["ADD_SECTIONS_CHAIN"] : '')
	),
	$component,
	($arParams["SHOW_TOP_ELEMENTS"] !== "N" ? array("HIDE_ICONS" => "Y") : array())
);

?>

<?if ($isVerticalFilter) {?>
	<div class="filter-checked-list">
	</div>
		<?//endif;?>
<div class="row">
	<? include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_vertical.php");  ?>
</div>
<?} else {
	include($_SERVER["DOCUMENT_ROOT"]."/".$this->GetFolder()."/section_horizontal.php");
	}
}
?>
<script>
	$(function() {
		var checkedElems = [];
		function creatCheckElem(elem) {
			var checkInputBox = elem.parent(),
					facetValue = checkInputBox.data('value'),
					checkText = checkInputBox.data('name');
			var filterCheckList = $('.filter-checked-list'),
				filterCheckElement = '<div class="filter-checked-element" data-facet="'+facetValue+'">'+checkText+'<span class="delete-elem">x</span></div>';
		
			if(elem.prop('checked') == true) {
				filterCheckList.append(filterCheckElement);
			}else if(elem.prop('checked') == false){
				$('.filter-checked-list .filter-checked-element').filter('div[data-facet="'+facetValue+'"]').remove();
			}

			
		}

		$('.check__input').on('click', function() {
			creatCheckElem($(this));
		});


		$('.filter-checked-list').on('click', '.delete-elem', function() {
			var elem = $(this).parent(),
				facet = elem.data('facet');
			elem.remove();
			//console.log($('label .bx-filter-input-checkbox').filter('span[data-value="'+facet+'"]').find('.check__input'));
			$('label .bx-filter-input-checkbox').filter('span[data-value="'+facet+'"]').find('.check__input').click();
		});

		$('.smartfilter .check__input').each(function(i,item) {
			creatCheckElem($(this));
		});
	});
</script>


