<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
global $APPLICATION;
//IncludeTemplateLangFile($_SERVER["DOCUMENT_ROOT"]."/bitrix/templates/".SITE_TEMPLATE_ID."/header.php");
//CJSCore::Init(array("fx"));

//\Bitrix\Main\UI\Extension::load("ui.bootstrap4");

$curPage = $APPLICATION->GetCurPage(true);
use Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/libs.css");
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/assets/css/styles.css");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/libs.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/app.js");
?><!DOCTYPE html>
<html xml:lang="<?=LANGUAGE_ID?>" lang="<?=LANGUAGE_ID?>">
<head>
	<title><?$APPLICATION->ShowTitle()?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
	<link rel="shortcut icon" type="image/x-icon" href="<?=SITE_DIR?>favicon.ico" />
	<? $APPLICATION->ShowHead(); ?>
</head>
<body>
<div id="panel"><? $APPLICATION->ShowPanel(); ?></div>
<div id="page" class="">
	<header>
		<nav class="navbar navbar-top p-0 d-none d-md-block">
			<div class="container">
				<div class="w-100">
					<div class="row">
						<div class="top-nav-l col-md-4">
							<ul>
								<li><a href="/catalog/produkty_pitaniya/">Продукты питания</a></li>
								<li><a href="/catalog/soputstvuyushchie_tovary/">Сопутствующие товары</a></li>
							</ul>
						</div>
						<div class="top-nav-r col-md-8">
								<? $APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "top",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "top"
	),
	false
);?>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<nav class="navbar navbar-top-second p-0">
			<div class="container">
				<div class="w-100">
					<div class="row">
						<div class="col-6 col-sm-4 col-md-3 col-lg-4 col-xl-5">
							<a href="/">
								<? $APPLICATION->IncludeFile(
									SITE_DIR.'include/company_logo.php',
									array(),
									array(
										'MODE'=>'html'
									)
								) ?>
							</a>
						</div>
						<div class="col-6 col-sm-8 col-md-9 col-lg-8 col-xl-7">
							<div class="row">
								<div class="d-none d-md-block col-md-4">
									<? $APPLICATION->IncludeComponent(
										"twofingers:location",
										".default",
									Array()
									) ?>
								</div>
								<div class="d-none d-sm-block col-sm-6 col-md-4">
									<span class="work-time">
									<? $APPLICATION->IncludeFile(
										SITE_DIR.'include/schedule.php',
										array(),
										array(
											'MODE'=>'html'
										)
									) ?>
									<? $APPLICATION->IncludeFile(
										SITE_DIR.'include/telephone.php',
										array(),
										array('MODE'=>'html')
									) ?>
									</span>
								</div>
								<div class="col-12 col-sm-6 col-md-4 pl-0 pl-sm-3">
									<div class="header-icons">
										<span class="header-icons_search">
											<a href="#" title="">
												<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"  viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><path d="M20,19.3l-5.8-5.8c1.3-1.4,2-3.3,2-5.4c0-4.5-3.7-8.1-8.1-8.1C3.7,0,0,3.7,0,8.1c0,4.5,3.7,8.1,8.1,8.1 c2.1,0,3.9-0.8,5.4-2.1l5.8,5.8L20,19.3z M1,8.1C1,4.2,4.2,1,8.1,1c3.9,0,7.2,3.2,7.2,7.2c0,3.9-3.2,7.2-7.2,7.2 C4.2,15.3,1,12.1,1,8.1z"/></svg>
											</a>
										</span>
											<?
												$APPLICATION->IncludeComponent(
													"bitrix:sale.basket.basket.line",
													"",
													array(
														"PATH_TO_BASKET" => SITE_DIR."personal/cart/",
														"PATH_TO_PERSONAL" => SITE_DIR."personal/",
														"SHOW_PERSONAL_LINK" => "N",
														"SHOW_NUM_PRODUCTS" => "Y",
														"SHOW_TOTAL_PRICE" => "Y",
														"SHOW_PRODUCTS" => "N",
														"POSITION_FIXED" =>"N",
														"SHOW_AUTHOR" => "Y",
														"PATH_TO_REGISTER" => SITE_DIR."login/",
														"PATH_TO_PROFILE" => SITE_DIR."personal/"
													),
													false,
													array()
												);
											?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
		<nav class="navbar navbar-top-menu bg-gray p-0" role="navigation">
			<div class="container justify-content-start">
				<a href="#" id="main-menu-btn" class="btn btn-lg btn-secondary d-flex align-items-center orange-gradient">
					<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 56 56" style="enable-background:new 0 0 56 56;" xml:space="preserve"><g><path d="M8,40c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S12.411,40,8,40z M8,54c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S11.309,54,8,54z"/><path d="M28,40c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S32.411,40,28,40z M28,54c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S31.309,54,28,54z"/><path d="M48,40c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S52.411,40,48,40z M48,54c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S51.309,54,48,54z"/><path d="M8,20c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S12.411,20,8,20z M8,34c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S11.309,34,8,34z"/><path d="M28,20c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S32.411,20,28,20z M28,34c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S31.309,34,28,34z"/><path d="M48,20c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S52.411,20,48,20z M48,34c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S51.309,34,48,34z"/><path d="M8,0C3.589,0,0,3.589,0,8s3.589,8,8,8s8-3.589,8-8S12.411,0,8,0z M8,14c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S11.309,14,8,14z"/><path d="M28,0c-4.411,0-8,3.589-8,8s3.589,8,8,8s8-3.589,8-8S32.411,0,28,0z M28,14c-3.309,0-6-2.691-6-6s2.691-6,6-6s6,2.691,6,6S31.309,14,28,14z"/><path d="M48,16c4.411,0,8-3.589,8-8s-3.589-8-8-8s-8,3.589-8,8S43.589,16,48,16z M48,2c3.309,0,6,2.691,6,6s-2.691,6-6,6s-6-2.691-6-6S44.691,2,48,2z"/></g></svg><svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 21 21" style="enable-background:new 0 0 21 21;" xml:space="preserve"><path d="M11.17,10.5l9.69-9.69c0.19-0.19,0.19-0.49,0-0.67c-0.19-0.19-0.49-0.19-0.67,0L10.5,9.83L0.81,0.14c-0.19-0.19-0.49-0.19-0.67,0c-0.19,0.19-0.19,0.49,0,0.67l9.69,9.69l-9.69,9.69c-0.19,0.19-0.19,0.49,0,0.67C0.23,20.95,0.36,21,0.48,21c0.12,0,0.24-0.05,0.34-0.14l9.69-9.69l9.69,9.69C20.28,20.95,20.4,21,20.52,21c0.12,0,0.24-0.05,0.34-0.14c0.19-0.19,0.19-0.49,0-0.67L11.17,10.5z"/></svg><span>Каталог товаров</span>
				</a>
				<a href="/aktsii/" class="d-none d-sm-block">
					Акции
				</a>
				<a href="/news/" class="d-none d-sm-block">
					Новости
				</a>
			</div>			
		</nav>
	</header>
	<div class="header-search-div">
		<section class="header-search shadow">
			<div class="container py-4">
				<div class="w-100 py-4">	
					<div class="row">
						<?php
						$APPLICATION->IncludeComponent(
	"bitrix:search.title", 
	"visual", 
	array(
		"CATEGORY_0" => array(
			0 => "iblock_1C",
		),
		"CATEGORY_0_TITLE" => "Каталог",
		"CHECK_DATES" => "N",
		"CONTAINER_ID" => "title-search",
		"INPUT_ID" => "title-search-input",
		"NUM_CATEGORIES" => "1",
		"ORDER" => "date",
		"PAGE" => "/catalog/",
		"SHOW_INPUT" => "Y",
		"SHOW_OTHERS" => "N",
		"TOP_COUNT" => "5",
		"USE_LANGUAGE_GUESS" => "Y",
		"COMPONENT_TEMPLATE" => "visual",
		"TEMPLATE_THEME" => "blue",
		"PRICE_CODE" => array(
			0 => "Интернет-магазин",
		),
		"PRICE_VAT_INCLUDE" => "Y",
		"PREVIEW_TRUNCATE_LEN" => "",
		"SHOW_PREVIEW" => "Y",
		"CONVERT_CURRENCY" => "N",
		"PREVIEW_WIDTH" => "75",
		"PREVIEW_HEIGHT" => "75",
		"CATEGORY_0_iblock_1C" => array(
			0 => "15",
		),
		"CATEGORY_0_iblock_catalog" => array(
			0 => "2",
		)
	),
	false
);
						?>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<div class="main-menu-div">
		<section class="main-menu shadow">
			<div class="container py-4">
				<div class="w-100 py-2">	
					<div class="row">
						<div class="main-menu__left d-none d-lg-block col-lg-4 col-xl-3">
							<h5 class="font-weight-bold mb-4">Каталог товаров</h5>
							<div class="text-gray small mb-5">
							<?use Bitrix\Main\Grid\Declension;
								$product_declension = new Declension('товар', 'товара', 'товаров');
								$sect_declension = new Declension('категории', 'категориях', 'категориях');
								?>
								<?=number_format(product_count(CATALOG_ID), 0, '', ' ').' '.$product_declension->get(product_count(CATALOG_ID));?> <br><br>
								в <?=catalog_sections_count(CATALOG_ID).' '.$sect_declension->get(catalog_sections_count(CATALOG_ID))?>
							</div>
							<h6 class="font-weight-bold">Новые производители</h6>	
							<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"devmenu", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "4",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "devmenu"
	),
	false
);?>
						</div>
						<div class="main-menu__right col col-12 col-lg-8 col-xl-9">
							<div class="row align-items-center flex-row-reverse">
								<div class="main-menu__questions col-12 col-sm-auto col-lg-5 col-xl-4 mb-3 text-gray">
									<div class="d-flex justify-content-between align-items-center">
										<span>Есть вопросы? <a class="text-gray" href="/kontakty/">Напишите нам</a></span>
										<a href="#"><svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 21 21" style="enable-background:new 0 0 21 21;" xml:space="preserve"><path d="M11.17,10.5l9.69-9.69c0.19-0.19,0.19-0.49,0-0.67c-0.19-0.19-0.49-0.19-0.67,0L10.5,9.83L0.81,0.14c-0.19-0.19-0.49-0.19-0.67,0c-0.19,0.19-0.19,0.49,0,0.67l9.69,9.69l-9.69,9.69c-0.19,0.19-0.19,0.49,0,0.67C0.23,20.95,0.36,21,0.48,21c0.12,0,0.24-0.05,0.34-0.14l9.69-9.69l9.69,9.69C20.28,20.95,20.4,21,20.52,21c0.12,0,0.24-0.05,0.34-0.14c0.19-0.19,0.19-0.49,0-0.67L11.17,10.5z"/></svg></a>
									</div>
								</div>
								<div class="col col-12 col-sm col-lg-7 col-xl-8 mb-3">
									<?php
									$APPLICATION->IncludeComponent(
										"bitrix:search.title", 
										"visual", 
										array(
											"CATEGORY_0" => array(
												0 => "iblock_1C",
											),
											"CATEGORY_0_TITLE" => "Каталог",
											"CHECK_DATES" => "N",
											"CONTAINER_ID" => "title-search1",
											"INPUT_ID" => "title-search-input1",
											"NUM_CATEGORIES" => "1",
											"ORDER" => "date",
											"PAGE" => "/catalog/",
											"SHOW_INPUT" => "Y",
											"SHOW_OTHERS" => "N",
											"TOP_COUNT" => "5",
											"USE_LANGUAGE_GUESS" => "Y",
											"COMPONENT_TEMPLATE" => "visual",
											"TEMPLATE_THEME" => "blue",
											"PRICE_CODE" => array(
												0 => "BASE",
												1 => "Кормолавка 1",
												2 => "Кормолавка 2",
												3 => "Кормолавка 3",
												4 => "Кормолавка 4",
												5 => "Кормолавка 5",
												6 => "Кормолавка 6",
											),
											"PRICE_VAT_INCLUDE" => "Y",
											"PREVIEW_TRUNCATE_LEN" => "",
											"SHOW_PREVIEW" => "Y",
											"CONVERT_CURRENCY" => "N",
											"PREVIEW_WIDTH" => "75",
											"PREVIEW_HEIGHT" => "75",
											"CATEGORY_0_iblock_1C" => array(
												0 => "6",
											),
											"CATEGORY_0_iblock_catalog" => array(
												0 => "2",
											)
										),
										false
									);
									?>
								</div>
								<div class="main-menu__categories col col-12">
									<div class="w-100">
									<?
									global $sectionsFilter;
									$sectionsFilter = ['!ID' => [234,235]];
									$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"menusectionlist", 
	array(
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COUNT_ELEMENTS" => "Y",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE",
		"FILTER_NAME" => "sectionsFilter",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "1C",
		"SECTION_CODE" => "",
		"SECTION_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_URL" => "",
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "UF_BACKGROUND_IMAGE",
			2 => "",
		),
		"SHOW_PARENT_NAME" => "Y",
		"TOP_DEPTH" => "2",
		"VIEW_MODE" => "LINE",
		"COMPONENT_TEMPLATE" => "menusectionlist"
	),
	false
);
										?>
										<!-- <div class="row d-flex flex-column flex-wrap align-items-baseline">
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Птицеводство</a></dt>
												<dd><a href="#">Несушка</a></dd>
												<dd><a href="#">Бройлер</a></dd>
												<dd><a href="#">Перепела</a></dd>
												<dd><a href="#">Индейка</a></dd>
												<dd><a href="#">Утка</a></dd>
											</dl>
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Свиноводство</a></dt>	
												<dd><a href="#">Поросята</a></dd>
												<dd><a href="#">Взрослые свиньи</a></dd>
											</dl>
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Кролиководство</a></dt>
												<dd><a href="#">Кормление животных</a></dd>
												<dd><a href="#">Содержание животных</a></dd>
												<dd><a href="#">Ветеринарная аптека</a></dd>
											</dl>
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Крупный рогатый скот</a></dt>	
												<dd><a href="#">Телята</a></dd>
												<dd><a href="#">Откорм КРС</a></dd>
												<dd><a href="#">Дойное стадо</a></dd>
											</dl>
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Козы и овцы</a></dt>
												<dd><a href="#">Кормление животных</a></dd>
												<dd><a href="#">Содержание животных</a></dd>
												<dd><a href="#">Ветеринарная аптека</a></dd>
											</dl>
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Лошади</a></dt>
												<dd><a href="#">Кормление животных</a></dd>
												<dd><a href="#">Содержание животных</a></dd>
												<dd><a href="#">Ветеринарная аптека</a></dd>
											</dl>
											<dl class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
												<dt><a href="#"><img src="">Домашние животные</a></dt>
												<dd><a href="#">Собаки</a></dd>
												<dd><a href="#">Кошки</a></dd>
												<dd><a href="#">Грызуны, хорьки</a></dd>
												<dd><a href="#">Рыбки</a></dd>
												<dd><a href="#">Птицы</a></dd>
											</dl>
											<div class="col col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4 d-md-none pt-3 pt-sm-0 text-center text-sm-left">
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
											</div>
										</div> -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
	
	<? if ($APPLICATION->GetCurPage(false) !== '/'): ?>
	<div class="breadcrumbs__box text-gray">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
					<?$APPLICATION->IncludeComponent(
						"bitrix:breadcrumb", 
						".default", 
						array(
							"PATH" => "",
							"SITE_ID" => "s1",
							"START_FROM" => "0",
							"COMPONENT_TEMPLATE" => ".default"
						),
						false
					);?>
				</div>
			</div>
		</div>
	</div>
	<? endif?>
	
	<div class="container">
		<div class="w-100">
			<? if ($APPLICATION->GetCurPage(false) !== '/'): ?>
			<div class="row">
				<div class="col-12 mt-3 mb-4">
					<h1 class="page__title mt-2 mb-3"><?$APPLICATION->ShowTitle(false);?></h1>
				</div>
			</div>
			<? print_r($arParams) ?>
			<? endif?>