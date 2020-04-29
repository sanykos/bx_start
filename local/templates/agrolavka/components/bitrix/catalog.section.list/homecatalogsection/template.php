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

<?if (0 < $arResult["SECTIONS_COUNT"]):
$tabs = null;
$content = null;
$count_content = 0;
$count_tabs = 0;
	ob_start();?>
	<?foreach($arResult['SECTIONS'] as &$arSection):
		$count_tabs++;
		//help_arr($arSection);
			if(!empty($arSection['CHILDREN'])):?>
			<div class="main-catalog-tab <?=$count_tabs == 1 ? 'active' : ''?>">
				<a href="#" title="<?=$arSection['NAME']?>"><?=$arSection['NAME']?></a>
			</div>
			<?endif;
	endforeach;
	$tabs = ob_get_clean();
	ob_start();
	foreach($arResult['SECTIONS'] as &$arSection):
		if(!empty($arSection['CHILDREN'])):
			$count_content++;?>
			<div class="catalog-items row <?=$count_content == 1 ? 'active': ''?>" <?if($count_content > 1):?>style="display:none;"<?endif;?> data-title="<?=$arSection['NAME']?>">
			<?$count_children = 0;?>
			<?foreach($arSection['CHILDREN'] as $children):
				$count_children++; if($count_children > 3) break;?>
			<div class="col-12 col-md-6 col-lg-4">
				<div class="card">
					<div class="card-body">
					<?//help_arr($children)
						$img_src = !empty($children['PICTURE']) ? $children['PICTURE']['SRC'] : PATH_NOPHOTO;
					?>
						<a href="<?=$children['SECTION_PAGE_URL']?>" title="<?=$children['NAME']?>"><img  class="catalog-item-img d-block" src="<?=$img_src?>" alt=""></a>
						<h5 class="card-title text-center"><a href="<?=$children['SECTION_PAGE_URL']?>" title="<?=$children['NAME']?>"><?=$children['NAME']?></a></h5>
					</div>
				</div>
			</div>
			<?endforeach;?>
			<div class="col-12 text-center">
				<a href="<?=$arSection['SECTION_PAGE_URL']?>" class="catalog-items-more">Посмотреть весь каталог</a>
			</div>
		</div>
		<?endif;
	endforeach;
	$content = ob_get_clean();
endif;?>

<div class="catalog-tabs-wrapper">
		<div class="main-catalog-tabs w-100 m-0 p-0">
			<?=$tabs?>
		</div>
	</div>
	<div class="catalog-items-wrapper">
		<?=$content?>
	</div>