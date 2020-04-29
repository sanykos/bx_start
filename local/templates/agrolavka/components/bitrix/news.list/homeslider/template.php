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
$this->setFrameMode(true);?>

<?if(!empty($arResult["ITEMS"])):?>
<section class="home-main-slider">
<div class="home-slider">
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

	if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
	<div id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
			width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
			height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
			title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>" />
	</div>
	<?endif;?>
<?endforeach;?>
</div>
</section>
<?endif;?>
