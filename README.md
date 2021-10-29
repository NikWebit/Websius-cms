# Cotont

**Cotont** — модульная CMS (**!в процессе разработки**) на базе PHP фреймворка Cotonti. Открытый исходный код, упор на безопасность, скорость и гибкость. Cледование принципам «собирательного фреймворка» и практически неограниченная настраиваемость внешнего вида и поведения.


## Основные особенности

Для пользователей, имеющих опыт использования других систем, станет полезным краткий обзор основных возможностей движка:

* Безопасность, надежность и простые API
* Продвинутая система создания экстраполей
* Уникальный шаблонизатор, быстрый и лёгкий
* Полное разделение PHP-кода и HTML-разметки
* Модульность, расширяемость и мультиязычность
* Настройка каждого параметра выходного HTML-кода
* Легковесность, ясность и малое потребление ресурсов
* Серверный кэш и оптимизация контента на стороне клиента


## Требования

Для установки Cotont необходимо чтобы на сервере было установлено следующее программное обеспечение:

* Веб Сервер (Apache, Nginx)
* PHP 8.0.0 +
* MySQL 5.0.7 +


## Конфигурация сервера

Для успешного запуска убедитесь, что PHP был скомпилирован с поддержкой:
* GD
* Hash
* Mbstring
* MySQL
* PCRE
* PDO and PDO_MySQL
* Sessions
* Zlib


## Опциональные компоненты

Если вам нужна поддержка перенаправлений URL-адресов SEF (Search Engine Friendly), ЧПУ,
понадобится `mod_rewrite` и возможность использовать локальные файлы` .htaccess`.


## Установка

1. Скопируйте datas/config-sample.php в datas/config.php и установите права на запись
 CHMOD 666 или CHMOD 664 (зависит от конфигурации вашего хостинга).

2. Также выставьте права на запись для папок (в том числе вложенных)
 CHMOD 777 или CHMOD 775:

* /datas/avatars
* /datas/cache (и все вложенные подпапки)
* /datas/defaultav
* /datas/extflds
* /datas/photos
* /datas/thumbs
* /datas/tmp
* /datas/users

3. Откройте браузер и запустите установщик: //ваш.домен/install.php

4. Следуйте инструкциям на экране до конца установки.


## ЧПУ и перенаправления

Если планируете использовать SEF URLs, ЧПУ:

* Установите плагин URL Editor
* Включите пресет "Handy" в Управление сайтом / Расширения / URL Editor / Конфигурация
* Для Apache: скопируйте правила в файл .htaccess из /sef-urls.htaccess
* Если используете Nginx, создайте в корне файл nginx.conf, скопируйте в него правила из /sef-urls.nginx.conf

## Архитектура

Cotont является легко расширяемой системой, как конструктор «Лего» или робот-трансформер. Это достигается благодаря разделению кода и поддержке различных видов расширений.

Некоторые из таких расширений поставляются в базовом пакете. Другие могут быть получены у сторонних разработчиков на свободной или коммерческой основе. Расширения могут взаимодействовать с системой и между собой с помощью общих точек входа — хуков (hooks). Расширения — общее название объединяющее как модули так и плагины (технически они очень схожи).

<dl>
  <dt>Ядро (cmf, фреймворк)</dt>
  <dd>Основным фундаментом всей системы является ядро, или проще говоря фреймворк, состоящий из набора библиотек, классов, функций. Это базовая инфраструктура для расширений.</dd>

  <dt>Расширения</dt>
  <dd>Этот термин подразумевает особый вид пространства, связывающий фоновую работу библиотек фреймворка с расширенным функционалом и представлением. Сюда можно отнести модули, плагины.</dd>
<dd>Если модули расширяют функционал ядра (например FORUMS: модуль создания форумов), то плагины могут быть как самостоятельными единицами (например CONTACT: форма обратной связи), так и расширяющими функционал модулей, например COMMENTS: плагин комментариев для модуля N. При этом они взаимодействуют между собой и могут кастомизироваться.</dd>
  <dt>Темы (шаблоны)</dt>
  <dd>Темы являются отдельной единицей, выводящей фасад (то что видит пользователь в браузере). </dd>
<dd>Раширения могут иметь свои файлы для темы. Например парсер будет искать файл шаблона, выводящий страницы статей (page.tpl) сначала в каталоге с темами, а если его там не будет, возьмёт его из папки tpl модуля PAGE.</dd>
</dl>

Совокупная слаженная работа тем c расширениями + фреймворк — это уже полноценная кастомизируемая CMS Cotont. Возможность самостоятельно создать нужный функционал без изменения ядра или других расширений, увеличивает радиус применения под разные задачи.

Например, установив модуль страниц PAGE (по сути блог), в любой момент можно установить модуль FORUMS (полноценный форум), и так далее, для разных расширений. В любой момент можно установить / удалить из админки, без необходимости правок ядра.


## Цель проекта

Ввиду того, что Cotonti больше позиционирует себя как фреймворк, каркас для разработчиков, было принято решение [темплейтнуть](https://docs.github.com/en/repositories/creating-and-managing-repositories/creating-a-repository-from-a-template) ветку, и развивать её в определённом направлении.

Основная цель — создание и развитие дружелюбной удобной CMS, как для пользователей, так и для вебмастеров и поисковых систем, сохраняя при этом особенность Cotonti быть одновременно CMF и CMS, модульность и расширяемость. Ориентация проекта — на рунет. Личный опыт будет описан отдельно, всему своё время.

Увидеть и понять проблемы, узкие места в любом движке, помогает повседневное взаимодействие с ним. Кто как не вебмастер точно знает, что нужно улучшить / изменить / добавить в существующий интерфейс. Зачастую ему приходится быть в одном лице верстальщиком, программистом, оптимизатором, админом, и даже копирайтером на своих проектах.


## Содействие

<dl>
  <dt>ПР (pull requests, пулл реквесты)</dt>
  <dd>Cotont это индивидуальный проект, поэтому <strong>пулл реквесты не принимаются</strong>. Если есть желание принять участие в командной работе, можно сделать это в качестве <a href="https://github.com/Cotonti/Cotonti/pulls">контрибьютера Cotonti</a>. Там есть команда разработчиков, и коллективная работа приветствуется.</dd>

  <dt>Сообщения (issues)</dt>
  <dd>Если вы обнаружили баг, неполадку, или просто хотите внести предложение по развитию системы, это можно сделать, <a href="https://github.com/NikWebit/Cotont/issues">отправив сообщение (issue)</a>.</dd>
</dl>


## Авторские права

Copyright © 2021, NikWebit

Copyright (c) 2008-2016, Cotonti Team

Copyright (c) 2001-2008, Neocrome

Все права защищены.


## Лицензия
[BSD 3-clause License](https://github.com/NikWebit/Cotont/blob/master/LICENCE)