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
?>

<section class="agrofilter-section">
    <form name="<?echo $arResult["FILTER_NAME"]."_form"?>" action="<?echo $arResult["FORM_ACTION"]?>" method="get" class="agrofilter-form smartfilter">
        <div class="agrofilter-collapse__box">
        <? foreach($arResult["ITEMS"] as $key=>$arItem):
            $key = $arItem["ENCODED_ID"];

            if(isset($arItem["PRICE"])):
                if ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0)
                    continue;
                $step_num = 4;
                $step = ($arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"]) / $step_num;
                $prices = array();
                if (Bitrix\Main\Loader::includeModule("currency"))
                {
                    for ($i = 0; $i < $step_num; $i++)
                    {
                        $prices[$i] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $arItem["VALUES"]["MIN"]["CURRENCY"], false);
                    }
                    $prices[$step_num] = CCurrencyLang::CurrencyFormat($arItem["VALUES"]["MAX"]["VALUE"], $arItem["VALUES"]["MAX"]["CURRENCY"], false);
                }
                else
                {
                    $precision = $arItem["DECIMALS"]? $arItem["DECIMALS"]: 0;
                    for ($i = 0; $i < $step_num; $i++)
                    {
                        $prices[$i] = number_format($arItem["VALUES"]["MIN"]["VALUE"] + $step*$i, $precision, ".", "");
                    }
                    $prices[$step_num] = number_format($arItem["VALUES"]["MAX"]["VALUE"], $precision, ".", "");
                }?>
            <div class="agrofilter-collapse-title">Цена</div>
            <div class="agrofilter-collapse__content">
            <div id="range-slider"></div>
               <div class="range-slider-inputs-wrp">
                    
                    <input type="text"
                        class="minCost"
                        value="<?echo $arItem["VALUES"]["MIN"]["HTML_VALUE"] ? $arItem["VALUES"]["MIN"]["HTML_VALUE"] : $arItem["VALUES"]["MIN"]["VALUE"]?>"
                        name="<?echo $arItem["VALUES"]["MIN"]["CONTROL_NAME"]?>"
                        id="<?echo $arItem["VALUES"]["MIN"]["CONTROL_ID"]?>"
                        data-start-value="<?=$arItem["VALUES"]["MIN"]["VALUE"]?>"/>
                        <span>-</span>
                        <input type="text"
                            class="maxCost"
                            name="<?echo $arItem["VALUES"]["MAX"]["CONTROL_NAME"]?>"
                            id="<?echo $arItem["VALUES"]["MAX"]["CONTROL_ID"]?>"
                            value="<?echo $arItem["VALUES"]["MAX"]["HTML_VALUE"] ? $arItem["VALUES"]["MAX"]["HTML_VALUE"] : $arItem["VALUES"]["MAX"]["VALUE"]?>"
                            data-start-value="<?=$arItem["VALUES"]["MAX"]["VALUE"]?>"/>
                </div>
                        
            </div>
            <? endif; ?>
        <? endforeach; ?>
            <!--  -->
            <div class="agrofilter-collapse-title">Зерно и зерносмеси</div>    
            <div class="agrofilter-collapse__content">
                <?for($i=0;$i<7;$i++):?>
                <label class="check option">
                    <input class="check__input" type="checkbox">
                    <span class="check__box"></span>
                    Первый
                </label>
                <?endfor;?>
            </div>
            <div class="agrofilter-collapse-title">Бренд</div>
            <div class="agrofilter-collapse__content">
                <?for($i=0;$i<7;$i++):?>
                <label class="check option">
                    <input class="check__input" type="checkbox">
                    <span class="check__box"></span>
                    Бренд
                </label>
                <?endfor;?>
            </div>
        </div>
        <div class="agrofilter-another">
                <?for($i=0;$i<3;$i++):?>
                <label class="check option">
                    <input class="check__input" type="checkbox">
                    <span class="check__box"></span>
                    Новинки
                </label>
                <?endfor;?>
        </div>
        <a type="submit" class="button reset-filter jsFilterApply" href="<?=$arResult["SEF_SET_FILTER_URL"]?>">Применить</a>
        <a class="button reset-filter jsFilterReset" href="<?=$arResult["SEF_DEL_FILTER_URL"]?>">Сбросить фильтр</a>
    </form>

    <div class="agrofilter-section__callback">
        <div class="callback-box">
        <?$APPLICATION->IncludeComponent(
                "bitrix:form",
                "",
                array(
                    "AJAX_MODE" => "Y",
                    "AJAX_OPTION_ADDITIONAL" => "",
                    "AJAX_OPTION_HISTORY" => "N",
                    "AJAX_OPTION_JUMP" => "N",
                    "AJAX_OPTION_STYLE" => "Y",
                    "CACHE_TIME" => "3600",
                    "CACHE_TYPE" => "A",
                    "CHAIN_ITEM_LINK" => "",
                    "CHAIN_ITEM_TEXT" => "",
                    "COMPONENT_TEMPLATE" => "forma",
                    "EDIT_ADDITIONAL" => "N",
                    "EDIT_STATUS" => "Y",
                    "IGNORE_CUSTOM_TEMPLATE" => "N",
                    "NOT_SHOW_FILTER" => array(
                        0 => "",
                        1 => "",
                    ),
                    "NOT_SHOW_TABLE" => array(
                        0 => "",
                        1 => "",
                    ),
                    "RESULT_ID" => $_REQUEST[RESULT_ID],
                    "SEF_MODE" => "N",
                    "SHOW_ADDITIONAL" => "Y",
                    "SHOW_ANSWER_VALUE" => "N",
                    "SHOW_EDIT_PAGE" => "N",
                    "SHOW_LIST_PAGE" => "N",
                    "SHOW_STATUS" => "N",
                    "SHOW_VIEW_PAGE" => "N",
                    "START_PAGE" => "new",
                    "SUCCESS_URL" => "",
                    "USE_EXTENDED_ERRORS" => "N",
                    "WEB_FORM_ID" => "1",
                    "VARIABLE_ALIASES" => array(
                        "action" => "action",
                    )
                ),
                false
            );?>
            <!-- <div class="callback-box__title"><strong>Есть вопросы? Оставьте телефон и мы перезвоним.</strong></div>
            <form action="" class="form-callback">
                    <input type="text" class="tel__input">
                    <button class="form-callback__btn transparentBtn">Отправить</button>
                    <div class="callback-box__privacy">
                        Нажимая на кнопку "Отправить" вы соглашаетесь с <a href="#">офертой</a> и <a href="#">политикой конфиденциальности</a>
                    </div>
            </form> -->
        </div>
    </div>
</section>