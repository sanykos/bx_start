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

<div class="row d-flex flex-column flex-wrap align-items-baseline">
	<?
	foreach($arResult['SECTIONS'] as &$arSection):
			//help_arr($arSection);
			$def_src = $arSection['PICTURE'] ? $arSection['PICTURE']['SRC'] : PATH_NOPHOTO;
			$svg_id = $arSection['UF_BACKGROUND_IMAGE'];
			$img_src = '';
			if($svg_id){
				$svg_arr = CFile::GetFileArray($svg_id);
				$img_src = $svg_arr['SRC'];
			}else {
				$img_src = $def_src;
			}
			?>
		<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
			<?if(!empty($arSection['CHILDREN'])):?>
			<dt>
				<a href="<?=$arSection['SECTION_PAGE_URL']?>">
					<img src="<?=$img_src?>"><?=$arSection['NAME']?>
				</a>
			</dt>
			<?	
				$child_count = 0;
				foreach($arSection['CHILDREN'] as $children): 
					$child_count++;
					if($child_count > 4) break;?>
					<dd><a href="<?=$children['SECTION_PAGE_URL']?>"><?=$children['NAME']?></a></dd>
				<?
					endforeach;
			endif;?>
			
		</dl>
	<?endforeach;
	?>
</div>
<!-- Для мобильного меню -->
<!-- <div class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 d-md-none pt-3 pt-sm-0 text-center text-sm-left">
												<dl class="d-inline-block bg-gray border-radius pt-2 pb-3 pl-5 pr-5 pl-sm-0">
													<i>+</i>
													<dt class="ml-xs-0 d-sm-none"><a href="">Акции</a></dt>
													<dt class="ml-xs-0 d-sm-none"><a href="">Новости</a></dt>
													<dt class="ml-xs-0"><a href="">Магазин фермеров</a></dt>
													<dt class="ml-xs-0"><a href="">База знаний</a></dt>
													<dd class="d-block"><a href="">О магазине</a></dd>
													<dd class="d-block"><a href="">Оплата и доставка</a></dd>
													<dd class="d-block"><a href="">Поставщики</a></dd>
													<dd class="d-block"><a href="">Сотрудничество</a></dd>
													<dd class="d-block"><a href="">Контакты</a></dd>
												</dl>
											</div> -->