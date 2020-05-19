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

<section class="account-section">
	<div class="w-100">
		<div class="row">
			<div class="col-12 col-md-8 col-lg-9 mx-auto mt-2 mb-5">
				<div class="card border-radius bg-gray border-0 overflow-hidden">
					<div class="news__img">
					<? $pic_src = $arResult["DETAIL_PICTURE"]["SRC"] ? $arResult["DETAIL_PICTURE"]["SRC"] : PATH_NOPHOTO; ?>
						<img class="w-100" src="<?=$pic_src?>"
										width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
										height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
										alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
										title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>">
					</div>
					<div class="p-4">
						<div class="news__title"></div>
						<script>$('h1').unwrap().unwrap().removeClass('mt-2 mb-3').addClass('mt-0 mb-2').appendTo(".news__title");</script>
						<div class="mt-2 mb-0 text-gray"><small><?=$arResult['DISPLAY_ACTIVE_FROM'];?></small></div>
					</div>
				</div>
				<div class="news-content mt-4 mb-0 text-justify">
					<?echo $arResult["DETAIL_TEXT"];?>
				</div>
			</div>
		</div>
	</div>
</section>