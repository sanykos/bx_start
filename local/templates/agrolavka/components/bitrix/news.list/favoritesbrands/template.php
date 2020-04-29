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
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;?>

<?

if(!empty($arResult["ITEMS"])):

	$feedbackDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
?>
<!-- <div class="card-items-favourite-filters mb-3">
	<form action="" class="favourite-filters__sort">
			<select name="" id="">
			<option selected="" value="Самые последние">Недавно добавленные</option>
			<option value="Самые первые">Самые первые</option>
		</select>
	</form>
</div> -->


<div class="cabinet-brands-section favorites__brands mb-5">

	<?foreach($arResult["ITEMS"] as $arItem):
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM'))); ?>
	<?
		$feed_count = !empty($arItem['PROPERTIES']['FEEDBACK']['VALUE']) ? count($arItem['PROPERTIES']['FEEDBACK']['VALUE']) : 0;
		$ask_count = !empty($arItem['PROPERTIES']['QUESTIONS']['VALUE']) ? count($arItem['PROPERTIES']['QUESTIONS']['VALUE']) : 0;
		$rating = $arItem['PROPERTIES']['RATING']['VALUE'] ? $arResult['PROPERTIES']['RATING']['VALUE'] : 0;
		$stars_width = round($rating/5*100,0);
	
	?>
	<div class="card card-item fav-brend-item w-100 px-4 py-2 mb-3" id="<?=$this->GetEditAreaId($arItem['ID']);?>" data-id="<?=$arItem['ID']?>">
		<div class="row align-items-center">
					<div class="align-self-start cabinet-brands-section__img-div mt-3 mb-0 col col-12 col-md-6 col-lg-4 col-xl-3">
					<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
							<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>"
								width="<?=$arItem["PREVIEW_PICTURE"]["WIDTH"]?>"
								height="<?=$arItem["PREVIEW_PICTURE"]["HEIGHT"]?>"
								alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>"
								title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
					<?else:?>
						<img src="<?=PATH_NOPHOTO?>">
					<?endif;?>
					</div>
					<div class="cabinet-brands-section__description-div mt-3 mb-0 col-12 col-md-12 col-lg-8 col-xl-9">
						<div class="cabinet-brands-section__description-div__header">
							<h5 class="mb-1 mt-0 font-weight-bold"><?echo $arItem["NAME"]?></h5>
							<?if($arItem['PROPERTIES']['ADDRESS']['VALUE']):?>
							<div class="cabinet-brands-section__description-div__header__address text-gray strong mb-1 py-1"><svg version="1.1" id="Capa__1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54.757 54.757" style="enable-background:new 0 0 54.757 54.757;" xml:space="preserve"><g><path d="M27.557,12c-3.859,0-7,3.141-7,7s3.141,7,7,7s7-3.141,7-7S31.416,12,27.557,12z M27.557,24c-2.757,0-5-2.243-5-5 s2.243-5,5-5s5,2.243,5,5S30.314,24,27.557,24z"></path><path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952 L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M41.099,31.431L27.38,51.243L13.639,31.4 C8.44,24.468,9.185,13.08,15.235,7.031C18.479,3.787,22.792,2,27.38,2s8.901,1.787,12.146,5.031 C45.576,13.08,46.321,24.468,41.099,31.431z"></path></g></svg> <?=$arItem['PROPERTIES']['ADDRESS']['VALUE']?></div><?endif;?>

							<div class="reviews-stars__average">
								<div class="products-rating-stars">
									<div class="stars-div" title="Средняя оценка <?=$rating?> из 5">
										<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"></path></svg>
										<div class="stars-div-stat green-gradient" style="width:<?=$stars_width?>%"><?=$rating?> из 5</div>
									</div>
								</div>
								<span class="stars-count ml-1"><small><a href="#" class="text-gray">(<?=$rating?> / 5)</a> <a href="#" class="text-gray"><?=$feed_count?> <?=$feedbackDeclension->get($feed_count)?></a></small></span>
							</div>
							<div class="row my-2 align-items-center">
								<div class="col-auto my-2">
									<a class="btn btn-outline-primary px-4 rounded-pill" href="<?=$arItem['DETAIL_PAGE_URL']?>">Подробнее</a>
								</div>
								<div class="col-auto my-2">
									<a class="favor-brand d-flex active" href="#" title="Убрать любимый бренд" data-id="<?=$arItem['ID']?>">
										<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 23 20" style="enable-background:new 0 0 23 20;" xml:space="preserve"><path class="transparent" d="M21.1,2.7c-1.1-1.5-2.4-2.2-3.8-2.2h-0.1c-2.7,0-5.3,2.5-5.8,3c-0.4-0.4-3-3-5.7-3H5.6c-1.4,0-2.7,0.7-3.8,2.2 c-1,1.3-1.4,2.7-1,4.4c0.8,4.2,5.8,8.9,10.8,12.2c5.1-3.3,10-8,10.8-12.2C22.6,5.5,22.2,4,21.1,2.7z"></path><path d="M21.7,2.4C20.4,0.9,18.9,0,17.2,0c-2.4-0.1-4.6,1.5-5.7,2.5c-1.1-1-3.3-2.6-5.7-2.5C4.1,0,2.6,0.9,1.3,2.4 c-1.2,1.4-1.6,3.1-1.2,5C1,11.9,6.3,16.8,11.5,20c5.2-3.2,10.5-8.1,11.4-12.6C23.2,5.6,22.8,3.9,21.7,2.4z M21.9,7.3 c-0.8,4-5.5,8.5-10.4,11.6C6.7,15.7,1.9,11.3,1.1,7.3c-0.3-1.6,0-3,1-4.2C3.2,1.7,4.5,1,5.8,1h0.1c2.6,0,5.1,2.4,5.5,2.8l0,0l0,0 C11.9,3.4,14.4,1,17,1h0.1c1.4,0,2.6,0.7,3.7,2.1C21.8,4.3,22.2,5.7,21.9,7.3z"></path></svg>
										<span>Любимый бренд</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?endforeach;?>
</div>
<?endif;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<br /><?=$arResult["NAV_STRING"]?>
<?endif;?>

