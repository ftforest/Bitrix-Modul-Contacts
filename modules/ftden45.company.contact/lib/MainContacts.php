<?php

namespace FTDen45\CompanyContact;

class MainContacts
{
    public static $module_id = 'ftden45.company.contact';

    public static function getField($name,$default = false)
    {
        return \COption::GetOptionString(static::$module_id, $name, $default);
    }

    public static function getPhone()
    {
        return static::getField("phone");
    }
    public static function getMailPost()
    {
        return static::getField("mail_post");
    }
    public static function getEmail()
    {
        return static::getField("email");
    }
    public static function getTelegram()
    {
        return static::getField("telegram");
    }
    public static function getWhatsapp()
    {
        return static::getField("whatsapp");
    }

}