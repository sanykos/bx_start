<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$level = 0;
$sectionList = array();
$parents = array();
$lastIndex = 0;
foreach($arResult['SECTIONS'] as &$arSection) {
   // print_r($arParams);
    $lev = $arSection['DEPTH_LEVEL'];

    if($arSection['DEPTH_LEVEL'] == 1) {
        $arSection['CHILDREN'] = array();
    }

    if($lev == 1) {
        $sectionList[] = $arSection;
        $lastIndenx = count($sectionList)-1;
        $parents[$lev] = &$sectionList[$lastIndenx];
    }else {
        $parents[$lev-1]['CHILDREN'][] = $arSection;
        $lastIndex = count($parents[$lev-1]['CHILDREN'])-1;
        $parents[$lev] = &$parents[$lev-1]['CHILDREN'][$lastIndex];
    }
}
$arResult['SECTIONS'] = $sectionList; 
?>