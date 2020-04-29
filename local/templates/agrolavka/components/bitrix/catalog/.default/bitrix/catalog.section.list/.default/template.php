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
global $APPLICATION;
?>


<?
//print_r(array_column($arResult['SECTIONS'], 'NAME'));
//print_r($arResult['SECTIONS']);

$lev = isset($arParams['DEPTH_LEVEL']) ? $arParams['DEPTH_LEVEL'] : 0;
switch($lev) {
    case 3 :
      // echo $DEPTH_LEVEL;
    case 4 :
              
    case 5 :
        //echo $DEPTH_LEVEL;
	case 6 :
	?>
	
	<?php
	break;
    default :
if(empty($arResult["SECTIONS"])) return;?>
<section class="agrocatalog">
    <img src="http://agrolavka-shop.ru/images/catalogbanner.jpg" alt="">
    <div class="agrocatalog-list">
        <div class="row">
            <?foreach($arResult["SECTIONS"] as &$arSection):?>
            <div class="col-md-6 col-sm-12">
                <div id="<?=$this->GetEditAreaId($arSection['ID']);?>" class="card agrocatalog-list__item">
                <?
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
                    <div class="card-body">
                        <img class="card-img" src="<?=$img_src?>" alt="">
                        <div class="wrapper-card-title d-flex align-items-end"><h5 class="card-title"><a onclick="" href="<?=$arSection['SECTION_PAGE_URL'];?>" title="<?=$arSection['NAME']; ?>"><?=$arSection['NAME']; ?></a></h5><span class="products-counter text-gray"><?=$arSection['ELEMENT_CNT'];?> товара</span></div>
                        <?if($arSection['DEPTH_LEVEL'] == 1 && $arSection['CHILDREN']):?>
                        <ul class="subcategories-list d-flex flex-wrap">
                        <?foreach($arSection['CHILDREN'] as $childred):?>
                            <li><a onclick="" href="<?=$childred['SECTION_PAGE_URL'];?>"><?=$childred['NAME']?></a></li>
                        <?endforeach;?>
                        </ul>
                        <?endif;?>
                    </div>
                </div>
            </div>
            <?endforeach;?>
        </div>
    </div>
</section>
<?
}
?>

        
