<?
// Путь к пустой картинке
define('PATH_NOPHOTO', '/local/templates/agrolavka/assets/img/nope_photo.svg');
// Тип цены
define('PRICE_TYPE', 'SCALED_PRICE_9');
// id каталога
define('CATALOG_ID', 15);

// функционал для отзывов
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", array("CAlskyReviews", "OnAfterReviewAdded"), 100, dirname(dirname(__FILE__)).'/components/alsky/reviews/class.php');	
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", array("CAlskyReviews", "OnReviewRemoved"), 100, dirname(dirname(__FILE__)).'/components/alsky/reviews/class.php');	

// привязка свойства бренд к элементам
//AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "OnAfterBrandAddsFrom1C");

function OnAfterBrandAddsFrom1C(&$arFields) {
	 $catalog_id = 15; // id инфоблока товарного каталога
	 $brands_id = 4; // id инфолока брендов
	 $brands_code = 'CML2_MANUFACTURER'; // код свойства списка брендов товарного каталога
	 $brands_xml = 'BRAND_XML_ID'; // код свойства XML_ID бренда
	 if ($arFields['IBLOCK_ID'] != $catalog_id) return;
	$property_enums = CIBlockPropertyEnum::GetList(Array(), Array("IBLOCK_ID"=> $catalog_id, "CODE"=>$brands_code));
	$brands = [];
	while($enum_fields = $property_enums->GetNext())
	{
	  $brands[$enum_fields["XML_ID"]] =  $enum_fields["VALUE"];
	}
		if ($brands) {
			//file_put_contents(dirname(__FILE__).'/text.txt', print_r($brands,1), FILE_APPEND | LOCK_EX);
			$arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_$brands_xml");
			$arFilter = Array("IBLOCK_ID"=>$brands_id);
			$res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
			while($ob = $res->GetNextElement())
			{
			 $arFields1 = $ob->GetFields();
			 $PRODUCT_ID = $arFields1['ID']; 
			 $el = new CIBlockElement;
			 $el->Update($PRODUCT_ID, ['ACTIVE' => 'N']); // предварительно выключаем все бренды
				 if (isset($brands[$arFields1["PROPERTY_$brands_xml"."_VALUE"]]) && $brands[$arFields1["PROPERTY_$brands_xml"."_VALUE"]]) {
					 $el = new CIBlockElement;
					$arLoadProductArray = Array(
					  "NAME"           => $brands[$arFields1["PROPERTY_$brands_xml"."_VALUE"]],
					  "ACTIVE"         => "Y",  
					  );

					$res1 = $el->Update($PRODUCT_ID, $arLoadProductArray);
					unset($brands[$arFields1["PROPERTY_$brands_xml"."_VALUE"]]);
				 }
			}
				 foreach ($brands as $key => $brand) {
					 file_put_contents(dirname(__FILE__).'/text.txt', print_r($brand,1), FILE_APPEND | LOCK_EX);
					$el = new CIBlockElement;

					$arLoadProductArray = Array(
					  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
					  "IBLOCK_ID"      => $brands_id,
					  "PROPERTY_VALUES"=> [$brands_xml => $key],
					  "NAME"           => $brand,
					  "ACTIVE"         => "Y",            // активен
					  );	
					if(!($PRODUCT_ID = $el->Add($arLoadProductArray)))
					  file_put_contents(dirname(__FILE__).'/text.txt', "Ошибка добавления бренда: ".$el->LAST_ERROR, FILE_APPEND | LOCK_EX);					  				  
				 }
		}
}


AddEventHandler("main", "OnPageStart", 'setPrice');	
function getPriceByCity() {
	$priceType = 'Кормолавка 1';
	$url = explode('.', $_SERVER['HTTP_HOST']);
	if ($url[0]) {
		switch($url[0]) {
			case 'msk' :
			$priceType = 'Кормолавка 5';
			break;
		}
	}
	
	return $priceType;
}

AddEventHandler("catalog", "OnGetOptimalPrice", "setPriceByCity");

function setPriceByCity($productId, $quantity, $arUserGroups, $renewal, &$arPrices, $siteID, $arDiscountCoupons) {
	$priceType = getPriceByCity();
	if (!$priceType) return true;
	$priceIds = [
		'BASE' => 1,
		'Кормолавка 1' => 2,
		'Кормолавка 2' => 3,
		'Кормолавка 3' => 4,
		'Кормолавка 4' => 5,
		'Кормолавка 5' => 6,
		'Кормолавка 6' => 7,
	];
	$prices = \CCatalogProduct::GetByIDEx($productId); 
	$PriceId = $priceIds[$priceType];
	if (!isset($prices['PRICES'][$PriceId])) return true;
	$price = $prices['PRICES'][$PriceId]['PRICE'];
	$arPrice =  [
		  'PRICE' => [
			 "ID" => $productId,
			 'CATALOG_GROUP_ID' => $priceType,
			 'PRICE' => $price,
			 'CURRENCY' => \Bitrix\Currency\CurrencyManager::getBaseCurrency(),
			 'ELEMENT_IBLOCK_ID' => $productId,
			 'VAT_INCLUDED' => "Y",
		  ],
	   ];
	  // file_put_contents(dirname(__FILE__).'/text.txt', print_r($arPrice,1)."\n", FILE_APPEND | LOCK_EX);
	   return $arPrice;
}


// Вывод массива
function help_arr($arr) {
	echo "<pre>".print_r($arr,1)."</pre>";
}

// Путь до blank картинки
function no_photo() {
	return SITE_TEMPLATE_PATH.'/assets/img/no_photo.png';
}


// Регистрация по email
AddEventHandler("main", "OnBeforeUserRegister", Array("CCustomRegHookEvent", "OnBeforeUserRegisterHandler"));
class CCustomRegHookEvent 
{ 
   function OnBeforeUserRegisterHandler(&$arFields) 
    { 
          $arFields["LOGIN"] = $arFields["EMAIL"]; 
    } 
}

// Авторизация через email
AddEventHandler("main", "OnBeforeUserLogin", array("CCustomAuthHookEvent", "DoBeforeUserLoginHandler"));
class CCustomAuthHookEvent {
        //  Проверяем пришел ли email или login и если email авторизуем по нему
        function DoBeforeUserLoginHandler( &$arFields )
        {
            $userLogin = $_POST["USER_LOGIN"];
            if (isset($userLogin))
            {
                $isEmail = strpos($userLogin,"@");
                if ($isEmail>0)
                {
                    $arFilter = Array("EMAIL"=>$userLogin);
                    $rsUsers = CUser::GetList(($by="id"), ($order="desc"), $arFilter);
                    if($res = $rsUsers->Fetch())
                    {
                        if($res["EMAIL"]==$arFields["LOGIN"])
                            $arFields["LOGIN"] = $res["LOGIN"];
                    }
                }
            }
        }
}


// Письмо с логином и паролем на почту при оформлении заказа
AddEventHandler('sale', 'OnOrderNewSendEmail', array('CSendOrderPass', 'OnOrderNewSendEmailHandler'));
AddEventHandler('main', 'OnBeforeUserAdd', array('CSendOrderPass', 'OnBeforeUserAddHandler'));
class CSendOrderPass {

	private static $newUserPass = false;
	private static $newUserLogin = false;
	//private static $toSend = [];
 
	public static function OnBeforeUserAddHandler($arFields) {
	   self::$newUserLogin = $arFields['LOGIN'];
	   self::$newUserPass = $arFields['PASSWORD'];	//    self::$toSend["LOGIN"] = $arFields['LOGIN'];
	}
 
	public static function OnOrderNewSendEmailHandler($ID, $eventName, &$arFields) {
	   if (self::$newUserPass === false) {
		  $arFields['PASSWORD'] = '';
	   } else {
		  $arFields['PASSWORD'] = "\n".'Ваш логин: '.self::$newUserLogin;
		  $arFields['PASSWORD'] .= "\n".'Ваш пароль: '.self::$newUserPass;
	   }
	}
 }
//  AddEventHandler("main", "OnAfterUserRegister", "OnAfterUserRegisterHandler");
//  function OnAfterUserRegisterHandler(&$arFields)
// {
//    if (intval($arFields["ID"])>0)
//    {
//       $toSend = Array();
//       $toSend["PASSWORD"] = $arFields["CONFIRM_PASSWORD"];
//       $toSend["EMAIL"] = $arFields["EMAIL"];
//       $toSend["USER_ID"] = $arFields["ID"];
//       $toSend["USER_IP"] = $arFields["USER_IP"];
//       $toSend["USER_HOST"] = $arFields["USER_HOST"];
//       $toSend["LOGIN"] = $arFields["LOGIN"];
//       $toSend["NAME"] = (trim ($arFields["NAME"]) == "")? $toSend["NAME"] = htmlspecialchars('<Не указано>'): $arFields["NAME"];
//       $toSend["LAST_NAME"] = (trim ($arFields["LAST_NAME"]) == "")? $toSend["LAST_NAME"] = htmlspecialchars('<Не указано>'): $arFields["LAST_NAME"];
//       CEvent::SendImmediate ("MY_USER_INFO", SITE_ID, $toSend);
//    }
//    return $arFields;
// }




// Меняем размер изображений
// На вход подаем массив изображения(Например $arResult["ITEM"]["DETAIL_PICTURE"])
function resize_img($img, $width = 190, $height = 190) {
	$image_src = null;
	$no_photo = PATH_NOPHOTO;
	if(!empty($img) && $img["ID"]) {
		$default_picture = $img;
		$default_picture_arr = CFile::GetFileArray($default_picture['ID']);
		$image_resize = CFile::ResizeImageGet($default_picture_arr, array("width" => $width, "height" => $height), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, false);
		$image_src = $image_resize["src"];
	} else {
		$image_src = $no_photo;
	}
	return $image_src;
}

// Количество товаров в каталоге
function product_count($catalog_id) {
	$arFilter = Array("IBLOCK_ID"=>$catalog_id, "ACTIVE"=>"Y");
	$res_count = CIBlockElement::GetList(Array(), $arFilter, Array(), false, Array());
	return $res_count;
}

// Количество разделов в инфоблоке
function catalog_sections_count($catalog_id) {
	$arFilter = ["IBLOCK_ID"=>$catalog_id];
	return CIBlockSection::GetCount($arFilter);
}

// Переводим байты в Кб, Мб, Гб, Тб
function get_file_size( $bytes ) {
 if ( $bytes < 1000 * 1024 ) 
	return number_format( $bytes / 1024, 2 ) . "кб";
elseif ( $bytes < 1000 * 1048576 )
  	return number_format( $bytes / 1048576, 2 ) . " мб";
elseif ( $bytes < 1000 * 1073741824 )
  	return number_format( $bytes / 1073741824, 2 ) . " гб";
else 
  	return number_format( $bytes / 1099511627776, 2 ) . " тб";
 }

