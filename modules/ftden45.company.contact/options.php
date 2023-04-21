<?php

use Bitrix\Sale as Sale;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Page\Asset;
use FTDen45\CompanyContact\Main as CompanyContact;


$module_id = 'ftden45.company.contact'; //обязательно, иначе права доступа не работают!

Loc::loadMessages($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php");
Loc::loadMessages(__FILE__);


\Bitrix\Main\Loader::includeModule($module_id);


$request = \Bitrix\Main\HttpApplication::getInstance()->getContext()->getRequest();

#Описание опций

//Asset::getInstance()->addJs('/local/modules/'.$module_id.'/install/assets/scripts/scripts.js');

$aTabs = array(
    array(
        "DIV" => "edit1",
        "TAB" => "Компания",
        "TITLE" => "Контакты компании",
        'OPTIONS' => array(
            array('phone', Loc::getMessage('FTDEN45_COMPANY_CONTACT_PHONE'),
                '+71234567890',
                array('text', 50)),
            array('mail_post', Loc::getMessage('FTDEN45_COMPANY_CONTACT_POST'),
                'г.Ачинск, ул.Свердлова, д. 15',
                array('text', 50)),
            array('email', Loc::getMessage('FTDEN45_COMPANY_CONTACT_EMAIL'),
                'mail@mail.ru',
                array('text', 50)),
            array('telegram', Loc::getMessage('FTDEN45_COMPANY_CONTACT_TELEGRAM'),
                '@login',
                array('text', 50)),
            array('whatsapp', Loc::getMessage('FTDEN45_COMPANY_CONTACT_WHATSAPP'),
                '+71234567890',
                array('text', 50)),
        )
    ),
);

#Сохранение

function saveOptions($aTabs,$request,$module_id) {
    foreach ($aTabs as $aTab)
    {
        //Или можно использовать __AdmSettingsSaveOptions($MODULE_ID, $arOptions);
        foreach ($aTab['OPTIONS'] as $arOption)
        {
            if (!is_array($arOption)) //Строка с подсветкой. Используется для разделения настроек в одной вкладке
                continue;

            if ($arOption['note']) //Уведомление с подсветкой
                continue;

            //Или __AdmSettingsSaveOption($MODULE_ID, $arOption);
            $optionName = $arOption[0];

            $optionValue = $request->getPost($optionName);

            Option::set($module_id, $optionName, is_array($optionValue) ? implode(",", $optionValue):$optionValue);
        }
    }
}

if ($request->isPost() && $request['Save'] && check_bitrix_sessid()) {
    saveOptions($aTabs,$request,$module_id);
}
if ($request->isPost() && $request['TestStatus'] && check_bitrix_sessid()) {
    saveOptions($aTabs,$request,$module_id);

    $setOrderId = \COption::GetOptionString('ftden45.testing', "order_id", "");
    $productIdDelete = 51769;
    //ExternalSuppliers::onOrderUpdate($setOrderId,[]);
    if (false) {
        $order = Sale\Order::load($setOrderId);
        $basket = $order->getBasket();
        $basketProducts = [];
        $basketSuppliersProductsDTO = [];
        foreach ($basket as $basketItem) {
            if ($basketItem->getProductId() == $productIdDelete) {
                $basketItem->delete();
                $basket->save();
            }
            $basketProducts[$basketItem->getProductId()] = $basketItem;//ExternalSupplierBasketProductDTO::newFromBasketProduct($basketItem);
            echo $basketItem->getProductId()."|";
        }
    }// end if

    ExternalSuppliers::onOrderSave($setOrderId);
}


#Визуальный вывод

$tabControl = new CAdminTabControl('tabControl', $aTabs);

?>
<? $tabControl->Begin(); ?>
<form method='post' action='<?echo $APPLICATION->GetCurPage()?>?mid=<?=htmlspecialcharsbx($request['mid'])?>&amp;lang=<?=$request['lang']?>' name='TESTING_CODE_settings'>

    <? foreach ($aTabs as $aTab):
            if($aTab['OPTIONS']):?>
        <? $tabControl->BeginNextTab(); ?>
        <? __AdmSettingsDrawList($module_id, $aTab['OPTIONS']); ?>

    <?      endif;
        endforeach; ?>

    <?
    $tabControl->BeginNextTab();

    $tabControl->Buttons(); ?>

    <div class="notes" id="notes">
    <input type="submit" name="Save" value="<?=Loc::getMessage('FTDEN45_COMPANY_CONTACT_SAVE')?>">
    <?=bitrix_sessid_post();?>
</form>
<? $tabControl->End(); ?>

