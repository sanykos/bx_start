<?php 
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
global $USER, $APPLICATION;
use Bitrix\Main,
Bitrix\Main\Localization\Loc as Loc,
Bitrix\Main\Loader,
Bitrix\Main\Config\Option,
Bitrix\Sale\Delivery,
Bitrix\Sale\PaySystem,
Bitrix\Sale\Basket,
Bitrix\Sale,
Bitrix\Sale\Order,
Bitrix\Sale\DiscountCouponsManager,
Bitrix\Catalog\Product,
Bitrix\Main\Context;


/**Склонения товаров */
// use Bitrix\Main\Grid\Declension;
// $yearDeclension = new Declension('год', 'года', 'лет');
// $yearDeclension->get($year);


if (CModule::IncludeModule("sale") && CModule::IncludeModule("catalog")) {

    if(isset($_POST['sendData']['id']) && !empty($_POST['sendData']['id'])) {
        
        //Получаем id сайта
        $siteId = Context::getCurrent()->getSite();
        // //Получаем id пользователя
        $idUser = $USER->GetID();
        $currencyCode = Option::get('sale', 'default_currency', 'RUB');
        
        $basket = \Bitrix\Sale\Basket::loadItemsForFUser($fuser, $siteId);
        
        $basket = Sale\Basket::loadItemsForFUser($idUser, $siteId);
        foreach ($basket as $key=>$basketItem) {
            $result = $basketItem->delete();
            if($result->isSuccess()) {
                $response['old_cart']['success'] = 'success'; 
            }else {
                $response['old_cart']['error'] = $result->getErrorMessages();
            }
        }

        $basket->save();

        //$basketNew = Basket::create($siteId);
        //echo $_POST['sendData']['id'];
        $order_id = $_POST['sendData']['id'];

        $order = Order::loadByAccountNumber($order_id);

        $basket = $order->getBasket();

       // print_r($basket);
       $basketNew = Basket::create($siteId);

       foreach($basket as $key => $basketItem) {
            $item = $basketNew->createItem('1C', $basketItem->getProductId());
            $fields = $basketItem->getFields();
           // print_r($fields);
            $item->setFields(array(
                'NAME' => $fields['NAME'],
                'BASE_PRICE' => $fields['BASE_PRICE'],
                'DISCOUNT_PRICE' => $fields['DISCOUNT_PRICE'],
                'QUANTITY' => $basketItem->getQuantity(),
                'CURRENCY' => $currencyCode,
                'LID' => $siteId,
                'PRODUCT_PROVIDER_CLASS'=>'\CCatalogProductProvider',));
        }

        $r = $basketNew->save();
        if($r->isSuccess()) {
           $response['success'] = 'success';
        }else {
          $response['error'] = $r->getErrorMessages();
        }

        echo json_encode($response);
    }
}