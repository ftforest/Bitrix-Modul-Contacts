<?php


function getPhone() {
    if(class_exists(\FTDen45\CompanyContact\MainContacts::class))
        return \FTDen45\CompanyContact\MainContacts::getPhone();
}
function getMailPost() {
    if(class_exists(\FTDen45\CompanyContact\MainContacts::class))
        return \FTDen45\CompanyContact\MainContacts::getMailPost();
}
function getEmail() {
    if(class_exists(\FTDen45\CompanyContact\MainContacts::class))
        return \FTDen45\CompanyContact\MainContacts::getEmail();
}
function getTelegram() {
    if(class_exists(\FTDen45\CompanyContact\MainContacts::class))
        return \FTDen45\CompanyContact\MainContacts::getTelegram();
}
function getWhatsapp() {
    if(class_exists(\FTDen45\CompanyContact\MainContacts::class))
        return \FTDen45\CompanyContact\MainContacts::getWhatsapp();
}