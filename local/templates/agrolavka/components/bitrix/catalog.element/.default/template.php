<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

global $USER, $APPLICATION;

use Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */
 
    $this->setFrameMode(true);
    $feed_count = !empty($arResult['PROPERTIES']['FEEDBACK']['VALUE']) ? count($arResult['PROPERTIES']['FEEDBACK']['VALUE']) : 0;
    $ask_count = !empty($arResult['PROPERTIES']['QUESTIONS']['VALUE']) ? count($arResult['PROPERTIES']['QUESTIONS']['VALUE']) : 0;

    //$APPLICATION->ShowTitle(false);

    $mainId = $this->GetEditAreaId($arResult['ID']);
    // echo $mainId;
    $name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
        ? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
        : $arResult['NAME'];
    $title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
        ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
        : $arResult['NAME'];
    $alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
        ? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
        : $arResult['NAME'];

    $price = $arResult["ITEM_PRICES"];

    $rating = $arResult['PROPERTIES']['RATING']['VALUE'];
    $stars_width = round($rating/5*100,0);

    $has_query = isset(parse_url($_SERVER['REQUEST_URI'])['query']) && parse_url($_SERVER['REQUEST_URI'])['query'];
    $ap = $has_query ? '&' : '?';
    $link_to_cart = $arResult["DETAIL_PAGE_URL"].'?action=ADD2BASKET&id='.$arResult['ID'];


    if(!$USER->IsAuthorized()) {
        $favorites = unserialize($_COOKIE['BITRIX_SM_favorites']);
        $favorites = array_map('intval', $favorites);
     }else {
          $idUser = $USER->GetID();
          $rsUser = CUser::GetByID($idUser);
          $arUser = $rsUser->Fetch();
          $favorites = $arUser['UF_FAVORITES'];
          $favorites_cookie = unserialize($_COOKIE['BITRIX_SM_favorites']);
         if(!empty($favorites_cookie)) {
             $favorites_cookie = array_map('intval', $favorites_cookie);
             $favorites = array_merge($favorites, $favorites_cookie);
             $favorites = array_unique($favorites);
         }
     }


?>
<section class="card-detail" data-id="<?=$arResult['ID']?>" itemscope itemtype="http://schema.org/Product">
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12">
            <?  $detail_image_src = '';
                if($arResult["PROPERTIES"]["MORE_PHOTO"] && $arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"]):?>
                <div class="card-detail__slider">
                    <ul class="detailSlider">
					<? foreach($arResult["PROPERTIES"]["MORE_PHOTO"]["VALUE"] as $img_id) : ?>
                        <li data-thumb="<?=CFile::GetPath($img_id)?>" data-src="<?=CFile::GetPath($img_id)?>">
                            <div class="d-flex align-items-center justify-content-center">
                                <img src="<?=CFile::GetPath($img_id)?>" />
                            </div>
                        </li>
					<?endforeach?>
                    </ul>
                </div>
            <?else:
                if($arResult["DETAIL_PICTURE"])
                    $detail_image_src = $arResult["DETAIL_PICTURE"]["SRC"];
                else
                    $detail_image_src = PATH_NOPHOTO?>
                <div class="card-detail__picture">
                    <img src="<?=$detail_image_src;?>" alt="<?=$alt?>">
                </div>
            <?endif;?>

            </div>
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12">
                <div class="card-detail__info">
                    <?if ($arParams['DISPLAY_NAME'] === 'Y'):?>
                   <div class="row">
                       <div class="col-12"><h1 class="card-detail__title"><?=$name?></h1></div>
                   </div>
                   <?endif;?>
                    <div class="row">
                        <div class="col-xl-7 col-lg-6 col-md-6 col-sm-12 card-detail__info-left">
                            <?if($arResult["PROPERTIES"]["CML2_ARTICLE"]):?>
                            <div class="card-detail__info-code"><span><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["NAME"]?>: </span><strong><?=$arResult["PROPERTIES"]["CML2_ARTICLE"]["VALUE"]?></strong></div>
                            <?endif;?>
                            <div class="card-detail__info-logo"><img src="" alt=""></div>
                            <div class="card-detail__info-feedback flex-md-wrap">
                                <div class="card-detail__info-reviews">
                                    <div class="products-rating-stars">
                                        <div class="stars-div" title="Средняя оценка 3 из 5">
                                            <svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
                                            <div class="stars-div-stat green-gradient" style="width:<?=$stars_width;?>%">3 из 5</div>
                                        </div>
						             </div>
                                    <span class="text-gray"><?=$feed_count.' отзывов'?></span>
                                </div>
                                <div class="card-detail__info-fav">
                                    <a class="favor <?=in_array($arResult['ID'], $favorites) ? 'active':'' ?>" href="#" title="Добавить в избранное" data-id="<?=$arResult['ID']?>">
                                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 23 20" style="enable-background:new 0 0 23 20;" xml:space="preserve"><path class="transparent" d="M21.1,2.7c-1.1-1.5-2.4-2.2-3.8-2.2h-0.1c-2.7,0-5.3,2.5-5.8,3c-0.4-0.4-3-3-5.7-3H5.6c-1.4,0-2.7,0.7-3.8,2.2 c-1,1.3-1.4,2.7-1,4.4c0.8,4.2,5.8,8.9,10.8,12.2c5.1-3.3,10-8,10.8-12.2C22.6,5.5,22.2,4,21.1,2.7z"/><path d="M21.7,2.4C20.4,0.9,18.9,0,17.2,0c-2.4-0.1-4.6,1.5-5.7,2.5c-1.1-1-3.3-2.6-5.7-2.5C4.1,0,2.6,0.9,1.3,2.4 c-1.2,1.4-1.6,3.1-1.2,5C1,11.9,6.3,16.8,11.5,20c5.2-3.2,10.5-8.1,11.4-12.6C23.2,5.6,22.8,3.9,21.7,2.4z M21.9,7.3 c-0.8,4-5.5,8.5-10.4,11.6C6.7,15.7,1.9,11.3,1.1,7.3c-0.3-1.6,0-3,1-4.2C3.2,1.7,4.5,1,5.8,1h0.1c2.6,0,5.1,2.4,5.5,2.8l0,0l0,0 C11.9,3.4,14.4,1,17,1h0.1c1.4,0,2.6,0.7,3.7,2.1C21.8,4.3,22.2,5.7,21.9,7.3z"/></svg>
                                        <span class="favor__text"><?=in_array($arResult['ID'], $favorites) ? 'В избранном':'В избранное' ?></span>
                                    </a>  
                                </div>  
                            </div>
                            <?if($arResult["PREVIEW_TEXT"]):?>
                            <div class="card-detail__info-brief">
                                <p><?=$arResult["PREVIEW_TEXT"]?></p>
                            </div>
                            <?endif;?>
                        </div>
                        <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12 card-detail__info-right">
                            <div>
                                <div class="card-detail__info-purchase">
										<? //$arResult['ITEM_PRICES'] - возможно несколько цен, пока что берем первую
										if ($arResult['ITEM_PRICES'] && isset($arResult['ITEM_PRICES'][0]) && $arResult['ITEM_PRICES'][0]['BASE_PRICE'] ) :
										$price_info = $arResult['ITEM_PRICES'][0];
										$price_discount = $price_info['PRINT_BASE_PRICE'];
										$price = $price_info['PRINT_PRICE'];
										?>
                                    <div class="purchase-container">
                                        <div class="price__box">
                                            <div class="current-price"><?=$price?></div>
											<? if ($price_info['DISCOUNT']) :?>
                                            <div class="before-discount"><?=$price_discount?></div>
											<?endif?>
                                        </div>
										<? if ($price_info['DISCOUNT']) :?>
                                        <div class="percent-discount">
                                            <span><span>-<?=$price_info['PERCENT']?>%</span></span>
                                        </div>
										<?endif?>
                                    </div>
									<?endif?>
                                    
                                    <div class="instock-container">
                                        <?if($arResult["PRODUCT"]["QUANTITY"] > 0):?>
                                        <div class="instock-icon"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px"><path fill-rule="evenodd" d="M 22.59375 3.5 L 8.0625 18.1875 L 1.40625 11.5625 L 0 13 L 8.0625 21 L 24 4.9375 Z"/></svg></div>
                                        <span >В наличии на складе</span>
                                        <?else:?>
                                        <span style="color:#ec6b03">Нет в наличии</span>
                                        <?endif;?>
                                    </div>
                                    <!-- Блок поделиться -->
                                        <div class="share-social-box">
                                            <div class="share-social-list">
                                                <?
                                                $APPLICATION->IncludeComponent(
                                                    "arturgolubev:yandex.share",
                                                    "",
                                                    Array(
                                                        "DATA_IMAGE" => "",
                                                        "DATA_RESCRIPTION" => "",
                                                        "DATA_TITLE" => "",
                                                        "DATA_URL" => "",
                                                        "SERVISE_LIST" => array("vkontakte","facebook","odnoklassniki","renren","sinaWeibo","surfingbird","tencentWeibo","tumblr","viber","whatsapp","skype","telegram"),
                                                        "TEXT_ALIGN" => "ar_al_left",
                                                        "TEXT_BEFORE" => "",
                                                        "VISUAL_STYLE" => "icons"
                                                    )
                                                );
                                                ?>
                                            </div>
                                            <a href="#" class="share-container" title="Поделиться">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="32px" height="32px"><path d="M 12.5 1 C 11.125 1 10 2.125 10 3.5 C 10 3.671875 10.019531 3.835938 10.050781 4 L 5.519531 6.039063 C 5.0625 5.414063 4.328125 5 3.5 5 C 2.125 5 1 6.125 1 7.5 C 1 8.875 2.125 10 3.5 10 C 4.332031 10 5.074219 9.582031 5.527344 8.949219 L 10.0625 10.964844 C 10.023438 11.136719 10 11.316406 10 11.5 C 10 12.875 11.125 14 12.5 14 C 13.875 14 15 12.875 15 11.5 C 15 10.125 13.875 9 12.5 9 C 11.667969 9 10.925781 9.417969 10.472656 10.050781 L 5.9375 8.039063 C 5.976563 7.863281 6 7.683594 6 7.5 C 6 7.3125 5.976563 7.128906 5.9375 6.953125 L 10.445313 4.914063 C 10.898438 5.570313 11.652344 6 12.5 6 C 13.875 6 15 4.875 15 3.5 C 15 2.125 13.875 1 12.5 1 Z M 12.5 2 C 13.335938 2 14 2.664063 14 3.5 C 14 4.335938 13.335938 5 12.5 5 C 11.664063 5 11 4.335938 11 3.5 C 11 2.664063 11.664063 2 12.5 2 Z M 3.5 6 C 4.335938 6 5 6.664063 5 7.5 C 5 8.335938 4.335938 9 3.5 9 C 2.664063 9 2 8.335938 2 7.5 C 2 6.664063 2.664063 6 3.5 6 Z M 12.5 10 C 13.335938 10 14 10.664063 14 11.5 C 14 12.335938 13.335938 13 12.5 13 C 11.664063 13 11 12.335938 11 11.5 C 11 10.664063 11.664063 10 12.5 10 Z"/></svg>
                                                <span>Поделиться</span>
                                            </a>
                                        </div>
                                        
                                    <?if($arResult["PRODUCT"]["QUANTITY"] > 0 && $price):?>
                                    <div class="addtobasket-container">
										<a class="addtobasket-btn" data-productname="<?=$name?>" data-action="add2basket" href="<?=$link_to_cart?>" title="Добавить в корзину" onclick="">Добавить в корзину</a>
                                    </div>
                                    <?else:?>
                                    <strong style="margin-top:20px; display:inline-block;">Цена по запросу</strong>
                                    <?endif;?>
                                </div>
                                <div class="card-detail__info-delivery">
                                <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => SITE_DIR."include/detail_delivery.php"), false);?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                <div class="card-detail__tabs">
                    <div class="tabs__box card-detail__tabs-container">
                        <ul class="tabs-menu card-detail__tabs-menu">
                            <li class="active">Описание</li>
                            <li data-action="reviews">Отзывы <?=($feed_count) ? '('.$feed_count.')' : ''?></li>
                            <li data-action="questions" data-feed="12">Вопросы и ответы <?=($ask_count) ? '('.$ask_count.')' : ''?></li>
                        </ul>
                        <hr>
                        <div class="tabs-content card-detail__tabs-content active">
                            <div class="row">
                                <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12">
                                    <?if($arResult['DETAIL_TEXT']):?>
                                        <p><?=$arResult['DETAIL_TEXT']?></p>
                                    <?endif?>
                                    <?//help_arr($arResult['PROPERTIES']);
                                    if($arResult['PROPERTIES']['FILES'] && !empty($arResult['PROPERTIES']['FILES']['VALUE'])):
                                        foreach($arResult['PROPERTIES']['FILES']['VALUE'] as $f_id):
                                            $f_arr = CFile::GetFileArray($f_id);?>
                                    <div class="card-detail__file" style="margin-bottom:10px;">
                                        <a href="<?=$f_arr['SRC']?>" title="Скачать файл" download>
                                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                            viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M382.56,233.376C379.968,227.648,374.272,224,368,224h-64V16c0-8.832-7.168-16-16-16h-64c-8.832,0-16,7.168-16,16v208h-64
                                                    c-6.272,0-11.968,3.68-14.56,9.376c-2.624,5.728-1.6,12.416,2.528,17.152l112,128c3.04,3.488,7.424,5.472,12.032,5.472
                                                    c4.608,0,8.992-2.016,12.032-5.472l112-128C384.192,245.824,385.152,239.104,382.56,233.376z"/>
                                            </g>
                                        </g>
                                        <g>
                                            <g>
                                                <path d="M432,352v96H80v-96H16v128c0,17.696,14.336,32,32,32h416c17.696,0,32-14.304,32-32V352H432z"/>
                                            </g>
                                        </g>
                                        </svg><span>Скачать файл: <?=$f_arr['ORIGINAL_NAME']?> (<?=get_file_size($f_arr['FILE_SIZE'])?>)</span></a>
                                    </div>
                                        <?endforeach;
                                    endif;?>
                                </div>
                                
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                <?//help_arr($arResult['PROPERTIES'])?>
                                <?if($arResult['PROPERTIES']):?>
                                    <div class="card-detail__properties">
                                        <ul class="p-dotten-line__box">
                                        <?foreach($arResult['PROPERTIES'] as $key => $prop):
                                        //help_arr($prop);
                                            if($prop['VALUE'] && 
                                                            $prop['NAME'] !== 'Артикул' && 
                                                            !is_array($prop['VALUE'])):
                                             if(!empty($prop['EXTRA_VALUES']) && $prop['EXTRA_VALUES']['UF_NAME']):?>
                                            <li class="p-dotten-line">
                                                <div class="p-dotten-line__left">
                                                    <div class="p-dotten-line__title"><strong><?=$prop['NAME'];?></strong></div>
                                                </div>
                                                <div class="p-dotten-line__right">
                                                    <div class="p-dotten-line__content">
                                                        <?=strip_tags($prop['EXTRA_VALUES']['UF_NAME']);?>
                                                    </div>
                                                </div>
                                            </li>
                                             <?else:?>
                                                <li class="p-dotten-line">
                                                <div class="p-dotten-line__left">
                                                    <div class="p-dotten-line__title"><strong><?=$prop['NAME'];?></strong></div>
                                                </div>
                                                <div class="p-dotten-line__right">
                                                    <div class="p-dotten-line__content">
                                                        <?=strip_tags($prop['VALUE']);?>
                                                    </div>
                                                </div>
                                            </li>
                                             <?endif;?>
                                            <?endif;?>
                                        <?endforeach;?>
                                        </ul>
                                    </div>
                                <?endif;?>
                                </div>
                            </div>
                        </div>
                        <div class="tabs-content card-detail__tabs-content feeds-tab" data-status="not_loaded" data-tab="reviews">
                            <div class="row">
                                    <div class="col-xl-9 col-lg-9 col-md-6 col-sm-12">
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
                                                    <a href="javascript:void(0)" title="Показать больше отзывов" data-action="showReviewsMore" data-page="1" data-count="5" data-all="<?=$feed_count?>" class="reviews-show-more">Показать больше отзывов</a>
                                                </nav>  
												<? endif; ?>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3  col-md-6 col-sm-12">
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
                                <div class="col-xl-9 col-lg-9  col-md-6 col-sm-12">
									<div class="questions-list">
									Вопросов нет...
									</div>
									<? if ($ask_count) : ?>
									<nav class="questions__nav">
										<a href="javascript:void(0)" title="Показать больше вопросов" data-action="showQuestionsMore" data-page="1" data-count="1" data-all="<?=$ask_count?>" class="reviews-show-more">Показать больше вопросов</a>
									</nav>  
									<? endif; ?>
                                </div>
                                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                    <div class="questions-aside">
                                        <aside>
										<? global $USER; if ($USER->IsAuthorized()) : ?>
												<form data-action="submit-Questions">
												<textarea class="form-control mb-2" rows="4" name="VALUE"></textarea>
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



<section class="similar-products">
    <div class="row">
        <div class="col">
            <h4 class="section-title section-title-h4">С этим товаром часто заказывают</h4>
<?

$section_path = $arResult['ORIGINAL_PARAMETERS']['CURRENT_BASE_PAGE'];
$section_path = trim($section_path, '/');
$section_path_arr = explode('/', $section_path);
//help_arr($section_path_arr);
global $arrNabor;
$arrNabor = [
	'!ID' => $arResult['ID'],
    [
        "LOGIC" => "OR",
        ["!SECTION_CODE" => $arResult['SECTION_CODE'], "SECTION_CODE" => $section_path_arr[1]]
    ],
	//'SECTION_CODE' => 'krupnyy_rogatyy_skot',
];
$APPLICATION->IncludeComponent(
	"bitrix:catalog.top",
	"",
	Array(
		"ACTION_VARIABLE" => "action",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"ADD_TO_BASKET_ACTION" => "ADD",
		"BASKET_URL" => "/personal/basket.php",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"COMPATIBLE_MODE" => "Y",
		"CONVERT_CURRENCY" => "N",
		"DETAIL_URL" => "",
		"DISPLAY_COMPARE" => "N",
		"ELEMENT_COUNT" => "4",
		"ELEMENT_SORT_FIELD" => "sort",
		"ELEMENT_SORT_FIELD2" => "id",
		"ELEMENT_SORT_ORDER" => "asc",
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrNabor",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "",
		"IBLOCK_TYPE" => "catalog",
		"LINE_ELEMENT_COUNT" => "1",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"OFFERS_LIMIT" => "2",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array("BASE","Кормолавка 1","Кормолавка 2","Кормолавка 3","Кормолавка 4","Кормолавка 5","Кормолавка 6"),
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "Y",
		"ROTATE_TIMER" => "30",
		"SECTION_URL" => "",
		"SEF_MODE" => "N",
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PAGINATION" => "Y",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "Y",
		"TEMPLATE_THEME" => "blue",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"VIEW_MODE" => "SECTION"
	)
);

?>

            <div class="similar-products__list d-flex flex-wrap">
                <div class="similar-products__item">
                <div class="card card-item">
				<div class="card-body">
					<img class="catalog-item-img d-block" src="http://agrolavka-shop.ru/images/00.jpg">
					<div class="card-title text-overflow-ellipsis"><a href="#" class="font-weight-bold" title="Корм для молодых уток, 4 кг">Корм для молодых уток, 4 кг</a></div>
					<div class="card-subtitle text-overflow-ellipsis"><a href="#" class="text-gray" title="Canagan">Canagan</a></div>
					<div class="catalog-stats w-100">
						<div class="products-rating">
							<div class="products-rating-stars">
								<div class="stars-div" title="Средняя оценка 3 из 5">
									<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
									<div class="stars-div-stat green-gradient" style="width:60%">3 из 5</div>
								</div>
							</div>
							<div class="products-rating-feedbacks" title="12 отзывов">
								<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 14" style="enable-background:new 0 0 16 14;" xml:space="preserve"><path d="M13.53,0H2.47C1.11,0,0,1.11,0,2.47v6.06C0,9.89,1.11,11,2.47,11h7.4c0.09,0,0.17,0.03,0.23,0.09L13,14h1l0-2.86c0-0.11,0.08-0.21,0.19-0.24C15.23,10.62,16,9.67,16,8.53V2.47C16,1.11,14.89,0,13.53,0z M15,8.53c0,0.76-1,1.47-1.33,1.46L13,10v2.59l-2.46-2.46C10.46,10.05,10.35,10,10.23,10H2.47C1.66,10,1,9.34,1,8.53V2.47C1,1.66,1.66,1,2.47,1h11.06C14.34,1,15,1.66,15,2.47V8.53z"/><polygon points="13,10 14,10 14,10 13,10 "/></svg>
								<span class="count">12<span>
							</div>
                        </div>
						<div class="products-availability available">Есть в наличии</div>
					</div>
					<div class="catalog-price w-100">
						<div class="products-price font-weight-bold">456 <span class="rub"><i>руб.</i></span></div>
						<div class="products-btns">
							<div class="products-fav">
								<a href="#" title="Добавить в избранное">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 23 20" style="enable-background:new 0 0 23 20;" xml:space="preserve"><path d="M21.7,2.4C20.4,0.9,18.9,0,17.2,0c-2.4-0.1-4.6,1.5-5.7,2.5C10.4,1.5,8.2-0.1,5.8,0C4.1,0,2.6,0.9,1.3,2.4 	c-1.2,1.4-1.6,3.1-1.2,5C1,11.9,6.3,16.8,11.5,20c5.2-3.2,10.5-8.1,11.4-12.6C23.2,5.6,22.8,3.9,21.7,2.4z M21.9,7.3 	c-0.8,4-5.5,8.5-10.4,11.6C6.7,15.7,1.9,11.3,1.1,7.3c-0.3-1.6,0-3,1-4.2C3.2,1.7,4.5,1,5.8,1c0,0,0.1,0,0.1,0 	c2.6,0,5.1,2.4,5.5,2.8l0,0l0,0C11.9,3.4,14.4,1,17,1c0,0,0.1,0,0.1,0c1.4,0,2.6,0.7,3.7,2.1C21.8,4.3,22.2,5.7,21.9,7.3z"/></svg>
								</a>
							</div>
							<div class="products-cart">
								<a class="btn btn-warning orange-gradient" href="#" title="Добавить в корзину">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M6.7,20c-1.4,0-2.6-1.2-2.6-2.6s1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6S8.2,20,6.7,20z M6.7,15.8c-0.9,0-1.6,0.7-1.6,1.6S5.9,19,6.7,19s1.6-0.7,1.6-1.6S7.6,15.8,6.7,15.8z"/></g><g><path d="M15.7,20c-1.4,0-2.6-1.2-2.6-2.6s1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6S17.1,20,15.7,20z M15.7,15.8c-0.9,0-1.6,0.7-1.6,1.6s0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6S16.5,15.8,15.7,15.8z"/></g><g><path d="M6.9,14c-0.7,0-1.3-0.1-1.6-0.2c-1.4-0.7-2.5-4.2-2.1-9.4C3.1,4,2.5,0.9,0.1,1L0,0c2.5-0.1,3.8,2.4,4.2,3.9h15.2l0.1,0.3c0,0.1,2.4,5.9-3.2,8.3C14.9,13.1,9.7,14,6.9,14z M4.2,5c-0.3,5,0.9,7.6,1.6,8c0.8,0.4,8.2-0.5,10.1-1.3C20,9.9,19,6.1,18.7,5H4.2z"/></g></svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
                <div class="similar-products__item plus__box d-flex align-items-center">
                    +
                </div>
                <div class="similar-products__item">
                <div class="card card-item">
				<div class="card-body">
					<img class="catalog-item-img d-block" src="http://agrolavka-shop.ru/images/00.jpg">
					<div class="card-title text-overflow-ellipsis"><a href="#" class="font-weight-bold" title="Корм для молодых уток, 4 кг">Корм для молодых уток, 4 кг</a></div>
					<div class="card-subtitle text-overflow-ellipsis"><a href="#" class="text-gray" title="Canagan">Canagan</a></div>
					<div class="catalog-stats w-100">
						<div class="products-rating">
							<div class="products-rating-stars">
								<div class="stars-div" title="Средняя оценка 3 из 5">
									<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 77 14" style="enable-background:new 0 0 77 14;" xml:space="preserve"><path style="fill:#FFFFFF;" d="M61.6,0H46.2H30.8H15.4H0v14h15.4h15.4h15.4h15.4H77V0H61.6z M12.22,13.8L7.8,11.48L3.38,13.8l0.84-4.92	L0.65,5.39l4.94-0.72L7.8,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L12.22,13.8z M27.62,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.58-3.48	l4.94-0.72L23.2,0.2l2.21,4.48l4.94,0.72l-3.58,3.48L27.62,13.8z M43.02,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72	L38.6,0.2l2.21,4.48l4.94,0.72l-3.57,3.48L43.02,13.8z M58.42,13.8L54,11.48l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L54,0.2	l2.21,4.48l4.94,0.72l-3.57,3.48L58.42,13.8z M73.82,13.8l-4.42-2.32l-4.42,2.32l0.84-4.92l-3.57-3.48l4.94-0.72L69.4,0.2l2.21,4.48	l4.94,0.72l-3.57,3.48L73.82,13.8z"/></svg>
									<div class="stars-div-stat green-gradient" style="width:60%">3 из 5</div>
								</div>
							</div>
							<div class="products-rating-feedbacks" title="12 отзывов">
								<svg version="1.1" id="Слой_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 16 14" style="enable-background:new 0 0 16 14;" xml:space="preserve"><path d="M13.53,0H2.47C1.11,0,0,1.11,0,2.47v6.06C0,9.89,1.11,11,2.47,11h7.4c0.09,0,0.17,0.03,0.23,0.09L13,14h1l0-2.86c0-0.11,0.08-0.21,0.19-0.24C15.23,10.62,16,9.67,16,8.53V2.47C16,1.11,14.89,0,13.53,0z M15,8.53c0,0.76-1,1.47-1.33,1.46L13,10v2.59l-2.46-2.46C10.46,10.05,10.35,10,10.23,10H2.47C1.66,10,1,9.34,1,8.53V2.47C1,1.66,1.66,1,2.47,1h11.06C14.34,1,15,1.66,15,2.47V8.53z"/><polygon points="13,10 14,10 14,10 13,10 "/></svg>
								<span class="count">12<span>
							</div>
						</div>
						<div class="products-availability available">Есть в наличии</div>
					</div>
					<div class="catalog-price w-100">
						<div class="products-price font-weight-bold">456 <span class="rub"><i>руб.</i></span></div>
						<div class="products-btns">
							<div class="products-fav">
								<a href="#" title="Добавить в избранное">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 23 20" style="enable-background:new 0 0 23 20;" xml:space="preserve"><path d="M21.7,2.4C20.4,0.9,18.9,0,17.2,0c-2.4-0.1-4.6,1.5-5.7,2.5C10.4,1.5,8.2-0.1,5.8,0C4.1,0,2.6,0.9,1.3,2.4 	c-1.2,1.4-1.6,3.1-1.2,5C1,11.9,6.3,16.8,11.5,20c5.2-3.2,10.5-8.1,11.4-12.6C23.2,5.6,22.8,3.9,21.7,2.4z M21.9,7.3 	c-0.8,4-5.5,8.5-10.4,11.6C6.7,15.7,1.9,11.3,1.1,7.3c-0.3-1.6,0-3,1-4.2C3.2,1.7,4.5,1,5.8,1c0,0,0.1,0,0.1,0 	c2.6,0,5.1,2.4,5.5,2.8l0,0l0,0C11.9,3.4,14.4,1,17,1c0,0,0.1,0,0.1,0c1.4,0,2.6,0.7,3.7,2.1C21.8,4.3,22.2,5.7,21.9,7.3z"/></svg>
								</a>
							</div>
							<div class="products-cart">
								<a class="btn btn-warning orange-gradient" href="#" title="Добавить в корзину">
									<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 20 20" style="enable-background:new 0 0 20 20;" xml:space="preserve"><g><path d="M6.7,20c-1.4,0-2.6-1.2-2.6-2.6s1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6S8.2,20,6.7,20z M6.7,15.8c-0.9,0-1.6,0.7-1.6,1.6S5.9,19,6.7,19s1.6-0.7,1.6-1.6S7.6,15.8,6.7,15.8z"/></g><g><path d="M15.7,20c-1.4,0-2.6-1.2-2.6-2.6s1.2-2.6,2.6-2.6s2.6,1.2,2.6,2.6S17.1,20,15.7,20z M15.7,15.8c-0.9,0-1.6,0.7-1.6,1.6s0.7,1.6,1.6,1.6s1.6-0.7,1.6-1.6S16.5,15.8,15.7,15.8z"/></g><g><path d="M6.9,14c-0.7,0-1.3-0.1-1.6-0.2c-1.4-0.7-2.5-4.2-2.1-9.4C3.1,4,2.5,0.9,0.1,1L0,0c2.5-0.1,3.8,2.4,4.2,3.9h15.2l0.1,0.3c0,0.1,2.4,5.9-3.2,8.3C14.9,13.1,9.7,14,6.9,14z M4.2,5c-0.3,5,0.9,7.6,1.6,8c0.8,0.4,8.2-0.5,10.1-1.3C20,9.9,19,6.1,18.7,5H4.2z"/></g></svg>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
                </div>
                <div class="similar-products__item equal__box d-flex align-items-center">
                    =
                </div>
                <div class="similar-products__item d-flex align-items-center" style="height: auto">
                    <div class="card" style="border:none;">
                        <div class="card-body">
                            <div class="similar-products__price d-flex align-items-center">
                                <div class="currrent-price">6 600 <span class="rub"><i>руб.</i></span></div>
                                <div class="old-price">6 680 <span class="rub"><i>руб.</i></span></div>
                            </div>
                            <a href="#" title="В корзину" class="btn-similar__tobasket transparentBtn">В корзину</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Скрипт для работы компонента bitrix:catalog.products.viewed -->
<script>
    var viewedCounter = {
    path: '/bitrix/components/bitrix/catalog.element/ajax.php',
    params: {
        AJAX: 'Y',
        SITE_ID: "<?= SITE_ID ?>",
        PRODUCT_ID: "<?= $arResult['ID'] ?>",
        PARENT_ID: "<?= $arResult['ID'] ?>"
    }
};
BX.ready(
    BX.defer(function(){
        BX.ajax.post(
            viewedCounter.path,
            viewedCounter.params
        );
    })
);
</script>