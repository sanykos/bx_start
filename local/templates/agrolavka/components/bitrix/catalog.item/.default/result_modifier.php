<?

use \Bitrix\Main\Loader;
use \Bitrix\Highloadblock as HL;

$arHighloadProperty = $arResult['ITEM']["PROPERTIES"]['BRAND_REF'];

$sTableName = $arHighloadProperty['USER_TYPE_SETTINGS']['TABLE_NAME'];

//$arBrand = [];

if ( Loader::IncludeModule('highloadblock') && !empty($sTableName) && !empty($arHighloadProperty["VALUE"]) )
{
  $hlblock = HL\HighloadBlockTable::getRow([
    'filter' => [
      '=TABLE_NAME' => $sTableName
    ],
  ]);

  if ( $hlblock )
  {
    $entity      = HL\HighloadBlockTable::compileEntity( $hlblock );
    $entityClass = $entity->getDataClass();
    
    $arRecords = $entityClass::getList([
      'filter' => [
        'UF_XML_ID' => $arHighloadProperty["VALUE"]
      ],
    ]);

    $arResult['ITEM']['BRAND'] = [];
    foreach ($arRecords as $record)
    {	
      $arRecord = [
        'ID'                  => $record['ID'],
        'UF_NAME'             => $record['UF_NAME'],
        'UF_SORT'             => $record['UF_SORT'],
        'UF_XML_ID'           => $record['UF_XML_ID'],
        'UF_LINK'             => $record['UF_LINK'],
        'UF_DESCRIPTION'      => $record['UF_DESCRIPTION'],
        'UF_FULL_DESCRIPTION' => $record['UF_FULL_DESCRIPTION'],
        'UF_DEF'              => $record['UF_DEF'],
        'UF_FILE'             => [],
        '~UF_FILE'            => $record['UF_FILE'],
      ];

    }

    $arResult['ITEM']['BRAND'] = $arRecord;
    //print_r($arRecord);
  }
}

//print_r($arResult['ITEM']['BRAND']);

//print_r($arResult);

 


