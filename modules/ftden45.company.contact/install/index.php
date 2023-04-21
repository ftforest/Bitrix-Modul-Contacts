<?

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config as Conf;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Loader;
use \Bitrix\Main\Entity\Base;
use \Bitrix\Main\Application;

Loc::loadMessages(__FILE__);
Class ftden45_company_contact extends CModule
{

	function __construct()
	{
		$arModuleVersion = array();
		include(__DIR__."/version.php");

        $this->MODULE_ID = 'ftden45.company.contact';
		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->MODULE_NAME = Loc::getMessage("FTDEN45_COMPANY_CONTACT_MODULE_NAME");
		$this->MODULE_DESCRIPTION = Loc::getMessage("FTDEN45_COMPANY_CONTACT_MODULE_DESC");

		$this->PARTNER_NAME = Loc::getMessage("FTDEN45_COMPANY_CONTACT_PARTNER_NAME");
		$this->PARTNER_URI = Loc::getMessage("FTDEN45_COMPANY_CONTACT_PARTNER_URI");

        $this->MODULE_SORT = 1;
	}

    //Определяем место размещения модуля
    public function GetPath($notDocumentRoot=false)
    {
        if($notDocumentRoot)
            return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
        else
            return dirname(__DIR__);
    }

    //Проверяем что система поддерживает D7
    public function isVersionD7()
    {
        return CheckVersion(\Bitrix\Main\ModuleManager::getVersion('main'), '14.00.00');
    }

    function InstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        return true;
    }

    function UnInstallDB()
    {
        Loader::includeModule($this->MODULE_ID);
        Option::delete($this->MODULE_ID);
        return true;
    }

	function InstallEvents()
    {
        return true;
    }

	function UnInstallEvents()
	{
        return true;
	}

    public function installFiles() {
        return true;
    }

    public function UnInstallFiles() {
        // удаляем настройки нашего модуля
        Option::delete($this->MODULE_ID);
    }

	function DoInstall()
	{
        global $APPLICATION;
        if($this->isVersionD7())
        {
            $this->InstallDB();
            $this->InstallEvents();
            //$this->InstallFiles();

            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
        }
        else
        {
            $APPLICATION->ThrowException(Loc::getMessage("FTDEN45_COMPANY_CONTACT_INSTALL_ERROR_VERSION"));
        }
	}

	function DoUninstall()
	{
        global $APPLICATION;

        $context = Application::getInstance()->getContext();
        $request = $context->getRequest();

        if($request["step"]<2)
        {
            $APPLICATION->IncludeAdminFile(Loc::getMessage("FTDEN45_COMPANY_CONTACT_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep1.php");
        }
        elseif($request["step"]==2)
        {
            $this->UnInstallFiles();
			$this->UnInstallEvents();

            if($request["savedata"] != "Y")
                $this->UnInstallDB();


            \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);


            $APPLICATION->IncludeAdminFile(Loc::getMessage("FTDEN45_COMPANY_CONTACT_UNINSTALL_TITLE"), $this->GetPath()."/install/unstep2.php");
        }
	}

}
?>