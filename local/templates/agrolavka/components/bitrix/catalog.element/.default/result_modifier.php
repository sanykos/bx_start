<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;

foreach($arResult['PROPERTIES'] as $key => $property) {
    if(!empty($property['USER_TYPE_SETTINGS'])) { 
        $table_name = $property['USER_TYPE_SETTINGS']['TABLE_NAME'];
        if ( Loader::IncludeModule('highloadblock') && !empty($table_name) && !empty($property["VALUE"])) {
            $hlblock = HL\HighloadBlockTable::getRow([
                'filter' => [
                  '=TABLE_NAME' => $table_name
                ],
              ]);

              if($hlblock) {
                $entity      = HL\HighloadBlockTable::compileEntity( $hlblock );
                $entityClass = $entity->getDataClass();

                $arRecords = $entityClass::getList([
                    'filter' => [
                      'UF_XML_ID' => $property["VALUE"]
                    ],
                  ]);

                  foreach($arRecords as $record) {
                        $arRecord = [
                            'ID' => $record['ID'],
                            'UF_NAME' => $record['UF_NAME'],
                            'UF_SORT' => $record['UF_SORT'],
                            'UF_XML_ID' => $record['UF_XML_ID'],
                            'UF_NAME' => $record['UF_NAME'] 
                            ];

                    //$arHighloadProperty['EXTRA_VALUE'][] = $arRecord;
                  }
                  $arResult['PROPERTIES'][$key]['EXTRA_VALUES'] = $arRecord;
              }
        }
    }
}



$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();


