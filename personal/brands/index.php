<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");

global $USER;

use Bitrix\Main\Grid\Declension;


$count_fav = 0;
if($USER->IsAuthorized()) {
	 $brandDeclension = new Declension('бренд', 'бренда', 'брендов');
	 $idUser = $USER->GetID();
     $rsUser = CUser::GetByID($idUser);
     $arUser = $rsUser->Fetch();
	 $favorites = $arUser['UF_BRANDFAV'];
	 $count_fav = count($favorites);
}else {
	LocalRedirect("/auth/");
}

?>

<section class="account-section favbrands__section">
	<div class="w-100">
		<div class="row">
			<div class="account-menu col-12 col-md-4 col-lg-3">
				<?php echo file_get_contents($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/personal/sect_sidebar.php')?>
			</div>
			<div class="col-12 col-md-8 col-lg-9">
				<h5 class="section-title section-title-h5">Любимые бренды <sup class="font-weight-normal text-gray"><small ><span class="count-fv-brand"><?=$count_fav?> </span><?=$brandDeclension->get($count_fav)?></small></sup></h5>
				<?if(!empty($favorites)):
					$GLOBALS['arrFilter'] = Array("ID" => $favorites);?>
					<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"favoritesbrands", 
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
		"FILTER_NAME" => "arrFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => "4",
		"IBLOCK_TYPE" => "catalog",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "20",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Любимые бренды",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "RATING",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
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
		"COMPONENT_TEMPLATE" => "favoritesbrands"
	),
	false
);?>

				<?else:?>
					<section class="reviews-content__empty mb-4">
					<div class="card bg-gray border-0 p-4 border-radius">
						<h6 class="section-title section-title-h6 pt-2 px-2">У вас еще нет любимых брендов</h5>
							<p class="text-gray px-2 mb-4">Исправьте это: перейдите к списку брендов и добавьте интересующие вас в избранное, они сразу же появятся в этом разделе!</p>
							<a class="btn btn-secondary orange-gradient border-0 py-0" href="/farms/">Все бренды</a>
					</div>
					</section>
				<?endif;?>
		</div>
	</div>
</section>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>