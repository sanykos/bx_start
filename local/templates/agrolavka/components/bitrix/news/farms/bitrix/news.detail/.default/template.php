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
$feed_count = !empty($arResult['PROPERTIES']['FEEDBACK']['VALUE']) ? count($arResult['PROPERTIES']['FEEDBACK']['VALUE']) : 0;
$ask_count = !empty($arResult['PROPERTIES']['QUESTIONS']['VALUE']) ? count($arResult['PROPERTIES']['QUESTIONS']['VALUE']) : 0;
$feedDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
$rating = $arResult['PROPERTIES']['RATING']['VALUE'] ? $arResult['PROPERTIES']['RATING']['VALUE'] : 0;
$addr = $arResult['PROPERTIES']['ADDRESS']['VALUE'];
?>
<section class="developer-section" data-action="feedbacks" data-iblock="<?=$arResult["IBLOCK_ID"]?>" data-id="<?=$arResult["ID"]?>">
	<div class="row d-block">
		<div class="developer-section__main-div h-90">
			<div class="align-self-start developer-section__img-div col col-12 col-md-5 col-lg-4 col-xl-3 d-block float-left">
			<?//help_arr($arResult)?>
		<?if($arResult["DETAIL_PICTURE"]["SRC"]):?>
		<img
			class="detail_picture"
			border="0"
			src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
			width="<?=$arResult["DETAIL_PICTURE"]["WIDTH"]?>"
			height="<?=$arResult["DETAIL_PICTURE"]["HEIGHT"]?>"
			alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
			title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
			/>
			<?else:?>
			<img class="detail_picture" src="<?=PATH_NOPHOTO?>" alt="" style="width:100px">
			<?endif;?>
			</div>
			<div class="align-self-start developer-section__description-div col-12 col-md-7 col-lg-8 col-xl-9 d-block float-right">
				<div class="developer-section__description-div__header">
					<h1 class="page__title mb-2"><?=$arResult["NAME"]?></h1>
					<?php if ($addr) : ?>
					<div class="developer-section__description-div__header__address text-gray strong mb-2 py-1"><svg version="1.1" id="Capa__1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 54.757 54.757" style="enable-background:new 0 0 54.757 54.757;" xml:space="preserve"><g><path d="M27.557,12c-3.859,0-7,3.141-7,7s3.141,7,7,7s7-3.141,7-7S31.416,12,27.557,12z M27.557,24c-2.757,0-5-2.243-5-5 s2.243-5,5-5s5,2.243,5,5S30.314,24,27.557,24z"></path><path d="M40.94,5.617C37.318,1.995,32.502,0,27.38,0c-5.123,0-9.938,1.995-13.56,5.617c-6.703,6.702-7.536,19.312-1.804,26.952 L27.38,54.757L42.721,32.6C48.476,24.929,47.643,12.319,40.94,5.617z M41.099,31.431L27.38,51.243L13.639,31.4 C8.44,24.468,9.185,13.08,15.235,7.031C18.479,3.787,22.792,2,27.38,2s8.901,1.787,12.146,5.031 C45.576,13.08,46.321,24.468,41.099,31.431z"></path></g></svg> <?=$addr?></div>
					<?php endif; ?>
					<div class="reviews-stars__average mb-4">
						<div class="products-rating-stars">
							<div class="stars-div" title="Средняя оценка <?=$rating?> из 5">
								<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
								<div class="stars-div-stat green-gradient" style="width:<?=(round($rating/5*100,1))?>%"><?=$rating?> из 5</div>
							</div>
						</div>
						<span class="stars-count ml-1"><small><a href="#" class="text-gray">(<?=$rating?> / 5)</a> <a href="#" class="text-gray"><?=$feed_count?> <?=$feedDeclension->get($feed_count)?></a></small></span>
					</div>
				</div>
				<div class="developer-section__description-div__text text-gray">
				<?echo $arResult["DETAIL_TEXT"];?>
				</div>
			</div>
			<div class="align-self-start developer-section__catalog-div col col-12 col-md-5 col-lg-4 col-xl-3 d-block float-left">
				<h4 class="section-title section-title-h4">Птицеводство</h4>
				<ul>
					<li><a href="#">Несушка</a></li>
					<li><a href="#">Перепела</a></li>
					<li><a href="#">Утка</a></li>
					<li><a href="#">Индейка</a></li>
				</ul>
				<a href="#" class="btn btn-outline-primary btn-round">Все товары бренда</a>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php if ($arResult['PROPERTIES']['DOCS']['VALUE']) : ?>
		<div class="developer-section__documents-div col-12 offset-md-5 col col-12 col-md-7 offset-lg-4 col-lg-8 offset-xl-3 col-xl-9">
			<h4 class="section-title section-title-h4">Документы</h4>
			<div class="row">
				<?php foreach ($arResult['PROPERTIES']['DOCS']['VALUE'] as $doc) :
				$file = CFile::GetFileArray($doc);
				$fileinfo = pathinfo($file['ORIGINAL_NAME']);
				$filename = $fileinfo['filename'];
				$icon_def = '<svg width="55" height="55" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 58 58" style="enable-background:new 0 0 58 58;" xml:space="preserve"><polygon style="fill:#EDEADA;" points="52,19 38,5 11,5 11,58 52,58 "/><polygon style="fill:#C1BCA4;" points="11,5 38,5 47,14 47,0 6,0 6,53 11,53 "/><g><path style="fill:#CEC9AE;" d="M19,26h25c0.552,0,1-0.447,1-1s-0.448-1-1-1H19c-0.552,0-1,0.447-1,1S18.448,26,19,26z"/><path style="fill:#CEC9AE;" d="M19,18h10c0.552,0,1-0.447,1-1s-0.448-1-1-1H19c-0.552,0-1,0.447-1,1S18.448,18,19,18z"/><path style="fill:#CEC9AE;" d="M44,32H19c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S44.552,32,44,32z"/><path style="fill:#CEC9AE;" d="M44,40H19c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S44.552,40,44,40z"/><path style="fill:#CEC9AE;" d="M44,48H19c-0.552,0-1,0.447-1,1s0.448,1,1,1h25c0.552,0,1-0.447,1-1S44.552,48,44,48z"/></g><polygon style="fill:#CEC9AE;" points="38,5 38,19 52,19 "/></svg>';
				$icon = $fileinfo['extension'] == 'pdf' ? '<img src="http://agrolavka-shop.ru/images/adobe-pdf-icon.webp">' : $icon_def;
				?>
				<div class="col col-12 mb-4 col-lg-6 col-xl-4">
					<div class="row">
						<div class="col col-auto developer-section__documents-div__icon">
							<a href="<?=$file['SRC']?>" download><?=$icon?></a>
						</div>
						<div class="col pl-0 developer-section__documents-div__text">
							<a href="<?=$file['SRC']?>" download><?=$filename?></a><br>
							<small><a href="<?=$file['SRC']?>" download><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 41.7 41.7" style="enable-background:new 0 0 41.7 41.7;" xml:space="preserve"><path class="st0" d="M31.6,21.8c0.4-0.4,0.4-1.1,0-1.6c-0.4-0.4-1.1-0.4-1.6,0l-8,8V1.7c0-0.6-0.5-1.1-1.1-1.1s-1.1,0.5-1.1,1.1v26.5l-8-8c-0.4-0.4-1.2-0.4-1.6,0c-0.4,0.4-0.4,1.1,0,1.6l10,10c0.4,0.4,1.1,0.4,1.6,0L31.6,21.8z M39.5,29.1c0-0.6,0.5-1.1,1.1-1.1s1.1,0.5,1.1,1.1v5.1c0,3.8-3.1,7-7,7H5.6c-3.1,0-5.6-2.5-5.6-5.6v-6.4C0,28.5,0.5,28,1.1,28s1.1,0.5,1.1,1.1v5.3c0,2.5,2,4.5,4.5,4.5H35c2.5,0,4.5-2,4.5-4.5V29.1z"/></svg> Скачать (<?=CFile::FormatSize($file['FILE_SIZE'])?>)</a></small>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($arResult['PROPERTIES']['PHONE']['VALUE'] || $arResult['PROPERTIES']['MAIL']['VALUE']) : ?>
		<div class="developer-section__contacts-div col-12 offset-md-5 col col-12 col-md-7 offset-lg-4 col-lg-8 offset-xl-3 col-xl-9 pb-3">
			<h4 class="section-title section-title-h4">Контакты</h4>
			<ul class="text-gray">
				<?php if ($arResult['PROPERTIES']['PHONE']['VALUE']) : ?>
				<li><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 482.6 482.6" style="enable-background:new 0 0 482.6 482.6;" xml:space="preserve"><g><path d="M98.339,320.8c47.6,56.9,104.9,101.7,170.3,133.4c24.9,11.8,58.2,25.8,95.3,28.2c2.3,0.1,4.5,0.2,6.8,0.2c24.9,0,44.9-8.6,61.2-26.3c0.1-0.1,0.3-0.3,0.4-0.5c5.8-7,12.4-13.3,19.3-20c4.7-4.5,9.5-9.2,14.1-14c21.3-22.2,21.3-50.4-0.2-71.9l-60.1-60.1c-10.2-10.6-22.4-16.2-35.2-16.2c-12.8,0-25.1,5.6-35.6,16.1l-35.8,35.8c-3.3-1.9-6.7-3.6-9.9-5.2c-4-2-7.7-3.9-11-6c-32.6-20.7-62.2-47.7-90.5-82.4c-14.3-18.1-23.9-33.3-30.6-48.8c9.4-8.5,18.2-17.4,26.7-26.1c3-3.1,6.1-6.2,9.2-9.3c10.8-10.8,16.6-23.3,16.6-36s-5.7-25.2-16.6-36l-29.8-29.8c-3.5-3.5-6.8-6.9-10.2-10.4c-6.6-6.8-13.5-13.8-20.3-20.1c-10.3-10.1-22.4-15.4-35.2-15.4c-12.7,0-24.9,5.3-35.6,15.5l-37.4,37.4c-13.6,13.6-21.3,30.1-22.9,49.2c-1.9,23.9,2.5,49.3,13.9,80C32.739,229.6,59.139,273.7,98.339,320.8z M25.739,104.2c1.2-13.3,6.3-24.4,15.9-34l37.2-37.2c5.8-5.6,12.2-8.5,18.4-8.5c6.1,0,12.3,2.9,18,8.7c6.7,6.2,13,12.7,19.8,19.6c3.4,3.5,6.9,7,10.4,10.6l29.8,29.8c6.2,6.2,9.4,12.5,9.4,18.7s-3.2,12.5-9.4,18.7c-3.1,3.1-6.2,6.3-9.3,9.4c-9.3,9.4-18,18.3-27.6,26.8c-0.2,0.2-0.3,0.3-0.5,0.5c-8.3,8.3-7,16.2-5,22.2c0.1,0.3,0.2,0.5,0.3,0.8c7.7,18.5,18.4,36.1,35.1,57.1c30,37,61.6,65.7,96.4,87.8c4.3,2.8,8.9,5,13.2,7.2c4,2,7.7,3.9,11,6c0.4,0.2,0.7,0.4,1.1,0.6c3.3,1.7,6.5,2.5,9.7,2.5c8,0,13.2-5.1,14.9-6.8l37.4-37.4c5.8-5.8,12.1-8.9,18.3-8.9c7.6,0,13.8,4.7,17.7,8.9l60.3,60.2c12,12,11.9,25-0.3,37.7c-4.2,4.5-8.6,8.8-13.3,13.3c-7,6.8-14.3,13.8-20.9,21.7c-11.5,12.4-25.2,18.2-42.9,18.2c-1.7,0-3.5-0.1-5.2-0.2c-32.8-2.1-63.3-14.9-86.2-25.8c-62.2-30.1-116.8-72.8-162.1-127c-37.3-44.9-62.4-86.7-79-131.5C28.039,146.4,24.139,124.3,25.739,104.2z"/></g></svg> Телефон для уточнения информации: <a href="tel:<?=$arResult['PROPERTIES']['PHONE']['VALUE']?>"><?=$arResult['PROPERTIES']['PHONE']['VALUE']?></a></li>
				<?php endif;
					if ($arResult['PROPERTIES']['MAIL']['VALUE']) :
				?>
				<li><svg height="560pt" viewBox="-17 -101 560 560" width="560pt" xmlns="http://www.w3.org/2000/svg"><path d="m462.5-5.582031h-400c-34.511719.011719-62.484375 27.988281-62.5 62.5v233.371093c.015625 34.511719 27.988281 62.492188 62.5 62.5h400c34.511719-.007812 62.484375-27.988281 62.5-62.5v-233.371093c-.015625-34.511719-27.988281-62.488281-62.5-62.5zm-400 25h400c18.003906.046875 33.453125 12.824219 36.875 30.496093l-236.875 132.003907-236.875-132.003907c3.421875-17.671874 18.871094-30.449218 36.875-30.496093zm400 308.25h-400c-20.683594-.0625-37.441406-16.816407-37.5-37.5v-212l231.375 128.996093c1.875 1.03125 3.980469 1.59375 6.125 1.628907 2.152344.023437 4.265625-.539063 6.125-1.628907l231.375-128.996093v212c-.015625 20.703125-16.796875 37.480469-37.5 37.5zm0 0"/></svg> Электронная почта: <a href="mailto:<?=$arResult['PROPERTIES']['MAIL']['VALUE']?>"><?=$arResult['PROPERTIES']['MAIL']['VALUE']?></a></li>
				<?php endif; ?>
			</ul>
		</div>
		<?php endif; ?>
		<div class="developer-section__tabs-div col-12 offset-md-5 col col-12 col-md-7 offset-lg-4 col-lg-8 offset-xl-3 col-xl-9">
			<div class="card-detail__tabs">
				<div class="tabs__box card-detail__tabs-container">
					<ul class="tabs-menu card-detail__tabs-menu">
						<li class="active">Отзывы <?=($feed_count) ? '('.$feed_count.')' : ''?></li>
						<li data-action="questions" data-feed="12" data-iblock="4">Вопросы и ответы <?=($ask_count) ? '('.$ask_count.')' : ''?></li>
					</ul>
					<hr>
					<div class="tabs-content card-detail__tabs-content active feeds-tab" data-status="not_loaded" data-tab="reviews">
						<div class="row">
							<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-4">
								<div class="card-detail__reviews">
									<section class="reviews-content text-gray">
										<div class="reviews-content__sort">
											<form action="" class="form-reviews__sort">
												<p>
													<select name="reviews_sort" id="reviews_sort">
														<option selected value="asc">Самые старые</option>
														<option value="desc">Самые новые</option>
													</select>
												</p>
											</form>
										</div>
										<div class="reviews-list">
											Отзывов нет...
										</div> 
										<? if ($feed_count) : ?>
										<nav class="reviews__nav">
											<a href="javascript:void(0)" title="Показать больше отзывов" data-action="showReviewsMore" data-page="1" data-count="1" data-all="<?=$feed_count?>" class="reviews-show-more">Показать больше отзывов</a>
										</nav>  
										<? endif; ?>										
									</section>
								</div>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
								<div class="reviews-aside">
									<aside>
										<? global $USER; if ($USER->IsAuthorized()) : ?>
												<form data-action="submit-Reviews">
												<input type="hidden" name="STARS" />
													<div class="products-rating-stars">
														<div style="cursor:pointer" class="stars-div stars-div-big my-2" data-action="setrating">
															<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"></path></svg>
															<div class="stars-div-stat green-gradient" style="width: 0%;"></div>
														</div>
													</div>
												<textarea class="form-control mb-2" rows="4" name="VALUE"></textarea>
													<?$APPLICATION->IncludeComponent("bitrix:main.file.input", "drag_n_drop",
													   array(
														  "INPUT_NAME"=>"FEED_ATTACH",
														  "MULTIPLE"=>"Y",
														  "MODULE_ID"=>"main",
														  "MAX_FILE_SIZE"=>"",
														  "ALLOW_UPLOAD"=>"I", 
														  "ALLOW_UPLOAD_EXT"=>""
													   ),
													   false
													);?>
                                                    <input type="submit" value="Написать отзыв" class="btn btn-reviews transparentBtn mt-2">
												</form>
													<? else : ?>
													<p>Только авторизованные пользователи могут оставить отзывы</p>
													<? endif; ?>
										<div class="reviews-stars__average">
											<div class="products-rating-stars">
												<div class="stars-div" title="Средняя оценка 4,5 из 5">
													<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
													 <div data-action="ratings-width" class="stars-div-stat green-gradient" style="width:0%"></div>
												</div>
											</div>
											<span class="stars-count"><span data-action="ratings-total">0</span>/5</span>
										</div>
										<hr>
									   <ul class="small-stars__list">
											<li>
												<div class="products-rating-stars">
													<div class="stars-div" title="Оценка 5 из 5">
														<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
														<div class="stars-div-stat green-gradient" style="width:100%">5 из 5</div>
													</div>
												</div>
												<div data-action="ratings-5" class="rs-counter text-gray">0</div>
											</li>
											<li>
												<div class="products-rating-stars">
													<div class="stars-div" title="Оценка 4 из 5">
														<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
														<div class="stars-div-stat green-gradient" style="width:80%">4 из 5</div>
													</div>
												</div>
												<div data-action="ratings-4" class="rs-counter text-gray">0</div>
											</li>
											<li>
												<div class="products-rating-stars">
													<div class="stars-div" title="Оценка 3 из 5">
														<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
														<div class="stars-div-stat green-gradient" style="width:60%">3 из 5</div>
													</div>
												</div>
												<div data-action="ratings-3" class="rs-counter text-gray">0</div>
											</li>
											<li>
												<div class="products-rating-stars">
													<div class="stars-div" title="Оценка 2 из 5">
														<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
														<div class="stars-div-stat green-gradient" style="width:40%">2 из 5</div>
													</div>
												</div>
												<div data-action="ratings-2" class="rs-counter text-gray">0</div>
											</li>
											<li>
												<div class="products-rating-stars">
													<div class="stars-div" title="Оценка 1 из 5">
														<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
														<div class="stars-div-stat green-gradient" style="width:20%">1 из 5</div>
													</div>
												</div>
												<div data-action="ratings-1" class="rs-counter text-gray">0</div>
											</li>
										</ul>
									</aside>
								</div>                         
							</div>
						</div>
					</div>
					<div class="tabs-content card-detail__tabs-content feeds-tab" data-status="not_loaded" data-tab="questions">
						<div class="row">
							<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12 mb-4">
								<div class="questions-list">
									Вопросов нет...
								</div>
								<? if ($ask_count) : ?>
									<nav class="questions__nav">
										<a href="javascript:void(0)" title="Показать больше вопросов" data-action="showQuestionsMore" data-page="1" data-count="1" data-all="<?=$ask_count?>" class="reviews-show-more">Показать больше вопросов</a>
									</nav>  
								<? endif; ?>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-4">
								<div class="questions-aside">
									<aside>
										<? global $USER; if ($USER->IsAuthorized()) : ?>
										<form data-action="submit-Questions">
										<textarea class="form-control mb-2" rows="4" name="VALUE"></textarea>
											<?/* $APPLICATION->IncludeComponent("bitrix:main.file.input", "drag_n_drop",
											   array(
												  "INPUT_NAME"=>"FEED_ATTACH",
												  "MULTIPLE"=>"Y",
												  "MODULE_ID"=>"main",
												  "MAX_FILE_SIZE"=>"",
												  "ALLOW_UPLOAD"=>"I", 
												  "ALLOW_UPLOAD_EXT"=>""
											   ),
											   false
											); */?>
											<input type="submit" value="Задать вопрос" class="btn btn-reviews transparentBtn mt-2">
										</form>
											<? else : ?>
											<p>Только авторизованные пользователи могут задавать вопросы</p>
											<? endif; ?>
									</aside>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>