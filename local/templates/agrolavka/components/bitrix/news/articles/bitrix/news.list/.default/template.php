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
$this->setFrameMode(true);

use Bitrix\Main\Grid\Declension;
$newsDeclension = new Declension('статью', 'статьи', 'статей');
?>

<div class="news-list articles-list row">
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
<?endif;?>
<?foreach($arResult["ITEMS"] as $arItem):?>
	<?$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	<div class="news-item mb-3 col-xl-4 col-lg-4 col-md-6 col-sm-12">
		<div class="card" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):
						$img_src = resize_img($arItem["PREVIEW_PICTURE"], 385, 300);?>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
					<img
							class="card-img-top"
							border="0"
							src="<?=$img_src?>"
							alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
							title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
							/>
					</a>
				<?else:?>
					<img
						class="card-img-top"
						border="0"
						src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
						width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
						height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
						alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
						title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"
						/>
				<?endif;?>
				<?else:?>
				<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" style="text-align:center;"><img src="<?=PATH_NOPHOTO?>" alt=""></a>
			<?endif;?>
			<div class="card-body">
			<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
				<div class="news-meta text-gray mb-4"><?echo $arItem["DISPLAY_ACTIVE_FROM"]?></div>
				<?endif?>
				<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
						<h5 class="card-title news-title mb-3 font-weight-bold"><a href="<?echo $arItem["DETAIL_PAGE_URL"]?>"><?echo $arItem["NAME"]?></a></h5>
					<?else:?>
						<h5 class="card-title news-title mb-3 font-weight-bold"><?echo $arItem["NAME"]?></h5>
					<?endif;?>
				<?endif;?>
				
				<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
					<p class="card-text text-gray"><?echo $arItem["PREVIEW_TEXT"];?></p>
				<?endif;?>
			</div>
			<?foreach($arItem["FIELDS"] as $code=>$value):?>
				<small>
				<?=GetMessage("IBLOCK_FIELD_".$code)?>:&nbsp;<?=$value;?>
				</small><br />
			<?endforeach;?>
			<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
				<small>
				<?=$arProperty["NAME"]?>:&nbsp;
				<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
					<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
				<?else:?>
					<?=$arProperty["DISPLAY_VALUE"];?>
				<?endif?>
				</small>
			<?endforeach;?>
		</div>
	</div>
	
	
<?endforeach;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):
	if($arResult["NAV_RESULT"]->nEndPage > 1 && $arResult["NAV_RESULT"]->NavPageNomer<$arResult["NAV_RESULT"]->nEndPage):
		$bxajaxid = CAjax::GetComponentID($component->__name, $component->__template->__name, $component->arParams['AJAX_OPTION_ADDITIONAL']);
		//help_arr($arResult["NAV_RESULT"]);
		$more_count = $arResult["NAV_RESULT"]->NavRecordCount - $arResult["NAV_RESULT"]-> NavPageSize;
		?>
		<div class="pagination-item mb-3 col-xl-4 col-lg-4 col-md-6 col-sm-12">
			<div class="card d-flex align-items-center justify-content-center" style="height: 100%">
				<div id="btn_<?=$bxajaxid?>" class="load-more d-flex justufy-content-center">
					<a data-ajax-id="<?=$bxajaxid?>" href="javascript:void(0)" data-show-more="<?=$arResult["NAV_RESULT"]->NavNum?>" data-next-page="<?=($arResult["NAV_RESULT"]->NavPageNomer + 1)?>" data-max-page="<?=$arResult["NAV_RESULT"]->nEndPage?>">   <div class="load-more__icon"></div><span class="load-more__text">Показать еще <?=$more_count.' '.$newsDeclension->get($more_count)?></span></a>
				</div>
			</div>
		</div>
	<?endif;
endif;?>


</div>
