# Вебсиус | Websius CMS

Модульная система управления веб-содержимым (сайтом). Открытый исходный код, упор на дружелюбность, скорость и гибкость. Cледование принципам «собирательного фреймворка», кастомизация внешнего вида и поведения.

!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<br>
**!В ПРОЦЕССЕ РАЗРАБОТКИ И ПЕРЕСТРОЙКИ ЯДРА**
На данный момент система обновляется под новые стандарты и технологии,
поэтому не готова к использованию до выхода релиза!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!<br>


## Для каких задач подходит

**Вебсиус | Websius CMS** — универсальная модульная система, которую можно расширить под различные задачи с помощью приложений (плагинов, модулей). Базовые возможности подходят для реализации различных проектов. От простейших визиток, лендингов, блогов, до новостных порталов. Есть возможность интеграции форума.

Благодаря разделению ядра, вида (скины) и приложений (модули, плагины), всегда можно реализовать нестандартный, совместимый с дальнейшими версиями интерфейс. От различных витрин (портфолио, электронных товаров) до полноценных кулинарных интерфейсов, всевозможных каталогов, фриланс бирж.


## Основные особенности

Для пользователей, имеющих опыт использования других систем, станет полезным краткий обзор основных возможностей движка:

* Безопасность, надежность и простое API
* Продвинутая система создания экстраполей
* Уникальный шаблонизатор, быстрый и лёгкий
* Полное разделение PHP-кода и HTML-разметки
* Модульность, расширяемость и мультиязычность
* Настройка каждого параметра выходного HTML-кода
* Легковесность, ясность и малое потребление ресурсов
* Серверный кэш и оптимизация контента на стороне клиента


## Требования системы

Для установки Вебсиус | Websius CMS необходимо чтобы на сервере было установлено следующее программное обеспечение:

* Веб Сервер:     (Apache, Nginx)
* PHP:            8.0.0 +
* MySQL/MariaDB:  5.0.7 +


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

1. Скопируйте /datas/configs/proto__config.php в /datas/configs/config.php и установите права на запись
 CHMOD 666 или CHMOD 664 (зависит от конфигурации вашего хостинга).

2. Также выставьте права на запись для папок CHMOD 777 или CHMOD 775:

* /datas/cache (и все вложенные подпапки)
* /datas/tmp
* /media/avatars
* /media/extflds
* /media/photos
* /media/thumbs
* /media/users

3. Откройте браузер и запустите установщик: //ваш.домен/install.php

4. Следуйте инструкциям на экране до конца установки.


## ЧПУ и перенаправления

Если планируете использовать SEF URLs, ЧПУ:

* Установите плагин URL Editor
* Включите пресет "Handy" в Управление сайтом / Расширения / URL Editor / Конфигурация
* Для Apache: скопируйте правила в файл .htaccess из /sef-urls.htaccess
* Если используете Nginx, создайте в корне файл nginx.conf, скопируйте в него правила из /sef-urls.nginx.conf

## Архитектура

Вебсиус | Websius CMS легко расширяется, как конструктор «Лего» или робот-трансформер. Это достигается благодаря разделению кода и поддержке различных видов приложений, взаимодействующих с API на базе ядра.

Приложения могут взаимодействовать с системой и между собой с помощью общих точек входа — хуков (hooks). Приложения — общее название объединяющее как модули так и плагины (технически они очень схожи).

<dl>
  <dt>Ядро</dt>
  <dd>Основным фундаментом всей системы является ядро, состоящее из набора библиотек, классов, функций. Это базовая инфраструктура для приложений.</dd>

  <dt>Приложения</dt>
  <dd>Этот термин подразумевает особый вид пространства, связывающий фоновую работу ядра с расширенным функционалом и представлением. Сюда можно отнести модули, плагины.</dd>
<dd>Если модули расширяют функционал ядра (например FORUMS: модуль создания форумов), то плагины могут быть как самостоятельными единицами (например CONTACT: форма обратной связи), так и расширяющими функционал модулей, например COMMENTS: плагин комментариев для модуля N. При этом они взаимодействуют между собой и могут кастомизироваться.</dd>
  <dt>Скины</dt>
  <dd>Скины являются отдельной единицей, выводящей фасад (то что видит пользователь в браузере). </dd>
<dd>Приложения могут иметь свои файлы для скина. Например парсер будет искать файл скина, выводящий страницы статей (page.tpl) сначала в каталоге со скинами, а если его там не будет, возьмёт его из папки tpl модуля PAGE.</dd>
</dl>

Совокупная слаженная работа скинов c приложениями + ядро — это уже полноценная кастомизируемая Вебсиус | Websius CMS. Возможность самостоятельно создать нужный функционал без изменения ядра или других приложений, увеличивает радиус применения под разные задачи.

Например, установив модуль страниц PAGE (по сути блог), в любой момент можно установить модуль FORUMS (полноценный форум), и так далее, для разных приложений. В любой момент можно установить / удалить из админки, без необходимости правок ядра.


## О проекте

За основу был взят форк PHP фреймворка Cotonti 0.9.19 c последней правкой от 2019-11. Cotonti больше позиционирует себя как фреймворк, каркас для разработчиков. Это подразумевает развитие в определённом направлении.

Чтобы реализовать свои задумки в контексте CMS, привнести что-то новое, было принято решение [темплейтнуть](https://docs.github.com/en/repositories/creating-and-managing-repositories/creating-a-repository-from-a-template) ветку.

Ориентация проекта — Рунет. Цель — создание и развитие дружелюбной, удобной CMS, как для пользователей, так и для вебмастеров и поисковых систем.


<dl>
  <dt>ПР (pull requests, пулл реквесты)</dt>
  <dd>Вебсиус | Websius CMS это индивидуальный проект, поэтому <strong>пулл реквесты не принимаются</strong>. Если есть желание принять участие в командной работе, можно сделать это в качестве <a href="https://github.com/Cotonti/Cotonti/pulls">контрибьютера Cotonti</a>. Там есть команда разработчиков, и коллективная работа приветствуется.</dd>

  <dt>Сообщения (issues)</dt>
  <dd>Если вы обнаружили баг, неполадку, или просто хотите внести предложение по развитию системы, это можно сделать, <a href="https://github.com/NikWebit/Websius-cms/issues">отправив сообщение (issue)</a>.</dd>
</dl>


## Лицензия

Вебсиус | Websius CMS распространяется по лицензии [BSD 3-clause License](https://github.com/NikWebit/Websius-cms/blob/master/LICENCE).

Copyright (c) 2021, Вебсиус | Websius CMS

Все права защищены.
