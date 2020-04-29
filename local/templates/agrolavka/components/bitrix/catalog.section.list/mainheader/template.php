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


?><div class="categories-slider <? echo $arCurView['CONT']; ?>"><?
if (0 < $arResult["SECTIONS_COUNT"])
{
			foreach ($arResult['SECTIONS'] as &$arSection)
			{
				$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
				$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);

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
				<div class="item" id="<? echo $this->GetEditAreaId($arSection['ID']); ?>">
					<a href="<? echo $arSection['SECTION_PAGE_URL']; ?>" title="<? echo $arSection['NAME']; ?>">
						<img src="<?=$img_src?>">
						<span><? echo $arSection['NAME']; ?></span>
					</a>
				</div>
				<?
			}
}
?></div>