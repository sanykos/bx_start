<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");?>
<section class="account-section">
	<div class="w-100">
		<div class="row">
			<div class="account-menu col-12 col-md-4 col-lg-3">
				<?php echo file_get_contents($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/personal/sect_sidebar.php')?>
			</div>
			<div class="col-12 col-md-8 col-lg-9">
				<h5 class="section-title section-title-h5">История заказов</h5>
				
				<div class="card-items card-items__list card-items-history mb-5">
					<?
					$APPLICATION->IncludeComponent(
						"bitrix:sale.personal.order", 
						"default", 
						array(
							"COMPONENT_TEMPLATE" => "default",
							"DETAIL_HIDE_USER_INFO" => array(
								0 => "0",
							),
							"PROP_1" => array(
							),
							"PROP_2" => array(
							),
							"ACTIVE_DATE_FORMAT" => "d.m.Y",
							"SEF_MODE" => "N",
							"CACHE_TYPE" => "A",
							"CACHE_TIME" => "3600",
							"CACHE_GROUPS" => "Y",
							"ORDERS_PER_PAGE" => "20",
							"PATH_TO_PAYMENT" => "/personal/order/payment/",
							"PATH_TO_BASKET" => "/personal/cart",
							"PATH_TO_CATALOG" => "/catalog/",
							"SET_TITLE" => "Y",
							"SAVE_IN_SESSION" => "Y",
							"NAV_TEMPLATE" => "",
							"DISALLOW_CANCEL" => "N",
							"CUSTOM_SELECT_PROPS" => array(
							),
							"HISTORIC_STATUSES" => array(
								0 => "F",
								1 => "N",
								2 => "P",
							),
							"RESTRICT_CHANGE_PAYSYSTEM" => array(
								0 => "P",
							),
							"REFRESH_PRICES" => "N",
							"ORDER_DEFAULT_SORT" => "ID",
							"ALLOW_INNER" => "N",
							"ONLY_INNER_FULL" => "N",
							"STATUS_COLOR_F" => "gray",
							"STATUS_COLOR_N" => "green",
							"STATUS_COLOR_P" => "yellow",
							"STATUS_COLOR_PSEUDO_CANCELLED" => "red"
						),
						false
					);
					?>
				</div>
			</div>
		</div>
	</div>
</section>




<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>