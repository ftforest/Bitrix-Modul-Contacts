###Модуль - ftden45.company.contact

###1) установить модуль

###2) подключить модуль к init.php
```phpt
\Bitrix\Main\Loader::includeModule('ftden45.company.contact');

include_once __DIR__ . '/include/functions.php'; // функции из модуля

```

###3) залить папку с файлом в папку local
```text
php_interface/functions.php

```

Список функций которые добавляет модуль на страницы сайта

```text
    Номер телефона: <?=getPhone();?><br>
    Ватсап: <?=getWhatsApp();?><br>
    Телеграм: <?=getTelegram();?><br>
    Email: <?=getEmail();?><br>
    Адрес: <?=getMailPost();?><br>
```