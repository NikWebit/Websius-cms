<?php

/**
 * Интерфейс установщика на русском языке.
 *
 * @package Install
 * @author NikWebit <https://websius.ru/contact>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @copyright (c) Вебсиус | Websius CMS <https://websius.ru>
 */
defined('WEBSIUS') or die('Wrong URL.');

if (defined('WE_INSTALL') || defined('WE_UPDATE')) {
    $L['Complete'] = 'Выполнено';
    $L['Finish'] = 'Завершить';
    $L['Install'] = 'Установить';
    $L['Next'] = 'Далее';

    $L['install_adminacc'] = 'Данные администратора';
    $L['install_body_title'] = 'Установщик Вебсиус';

    $L['install_files_chmod'] = [
        'file' => substr(decoct(WE_CHMOD['file']), -4),
        'wfile' => substr(decoct(WE_CHMOD['wfile']), -4)
    ];
    $L['install_body_message1'] = 'Этот скрипт поможет вам осуществить первичную установку и настройку Вебсиус.';
    $L['install_body_message2'] = 'Рекомендуем создать в папке datas/configs/ файл ' . basename($cfgs_file['cfg_install']) . ', скопировать в него содержимое файла datas/configs/prototype/' . basename($cfgs_file['cfg_proto']) . ' и установить на него права CHMOD ' . $L['install_files_chmod']['wfile'] . '.';
    $L['install_body_message3'] = 'Вам необходимо <strong>предварительно создать пустую базу данных</strong> с указанным выше именем на вашем сервере, если у данного пользователя нет прав на создание новых БД.';
    $L['install_chmod_value'] = 'CHMOD {$chmod}';
    $L['install_complete'] = 'Установка Вебсиус успешно завершена!';
    $L['install_complete_note'] = 'Удалите install.php и установите на datas/configs/' . basename($cfgs_file['cfg']) . ' права CHMOD ' . $L['install_files_chmod']['file'] . '. Это необходимо для повышения безопасности вашего сайта.';
    $L['install_db'] = 'Настройки базы данных MySQL';
    $L['install_db_host'] = 'Сервер СУБД';
    $L['install_db_user'] = 'Пользователь';
    $L['install_db_pass'] = 'Пароль';
    $L['install_db_port'] = 'Порт сервера';
    $L['install_db_port_hint'] = 'Только если отличается от порта по умолчанию';
    $L['install_db_name'] = 'Имя базы данных';
    $L['install_db_x'] = 'Префикс таблиц';
    $L['install_dir_not_found'] = 'Каталог установки не найден';
    $L['install_error_config'] = 'Не удаётся создать или отредактировать файл конфигурации. Скопируйте содержимое файла datas/configs/prototype/' . basename($cfgs_file['cfg_proto']) . ' в datas/configs/' . basename($cfgs_file['cfg_install']) . ' и установите на него права CHMOD ' . $L['install_files_chmod']['wfile'] . '.';
    $L['install_error_sql'] = 'Не удалось подключиться к базе MySQL. Проверьте настройки подключения.';
    $L['install_error_sql_host'] = 'Укажите адрес сервера';
    $L['install_error_sql_user'] = 'Укажите имя пользователя';
    $L['install_error_sql_db_name'] = 'Укажите имя базы данных';
    $L['install_error_sql_db'] = 'Не удалось выбрать базу MySQL. Проверьте настройки подключения.';
    $L['install_error_sql_ext'] = 'Для запуска Вебсиус необходимо PHP-расширение pdo_mysql';
    $L['install_error_sql_script'] = 'Выполнение SQL-скрипта завершилось неудачно: {$msg}';
    $L['install_error_mainurl'] = 'Укажите основной URL вашего сайта';
    $L['install_error_mbstring'] = 'Для запуска Вебсиус необходимо расширение PHP mbstring';
    $L['install_error_missing_file'] = 'Отсутствует файл {$file}. Загрузите его для продолжения установки.';
    $L['install_error_php_ver'] = 'Для запуска Вебсиус необходим PHP ' . WEBSIUS['php-min'] . ' и выше. Ваша версия {$ver}';
    $L['install_misc'] = 'Дополнительные настройки';
    $L['install_misc_lng'] = 'Основной язык';
    $L['install_misc_theme'] = 'Основная тема оформления';
    $L['install_misc_url'] = 'Основной URL сайта (без слеша в конце)';
    $L['install_parsing'] = 'Режим парсинга';
    $L['install_parsing_hint'] = 'Режим парсинга вступит в силу глобально для всего сайта. Если вы выберете HTML, то все имеющиеся элементы будут автоматически переведены в HTML. Эта операция не может быть отменена.';
    $L['install_permissions'] = 'Права на файлы и каталоги';
    $L['install_recommends'] = 'Рекомендуется';
    $L['install_requires'] = 'Требуется';
    $L['install_retype_password'] = 'Повторите пароль';
    $L['install_step'] = 'Шаг {$step} из {$total}';
    $L['install_title'] = 'Установка Вебсиус';
    $L['install_update'] = 'Обновление Вебсиус';
    $L['install_update_config_error'] = 'Невозможно обновить datas/configs/' . basename($cfgs_file['cfg']) . '. Пожалуйста, установите CHMOD ' . $L['install_files_chmod']['file'] . ' или ' . $L['install_files_chmod']['wfile'] . ' на этот файл и попробуйте снова. Если это не помогло, убедитесь, что файл datas/configs/prototype/' . basename($cfgs_file['cfg_proto']) . ' существует.';
    $L['install_update_config_success'] = 'Файл datas/configs/' . basename($cfgs_file['cfg']) . ' обновлен';
    $L['install_update_error'] = 'Обновление не выполнено';
    $L['install_update_nothing'] = 'Обновление не требуется';
    $L['install_update_patch_applied'] = 'Установить патч {$f}: {$msg}';
    $L['install_update_patch_error'] = 'Ошибка установки патча {$f}: {$msg}';
    $L['install_update_patches'] = 'Установленные патчи:';
    $L['install_update_success'] = 'Успешное обновление до версии {$rev}';
    $L['install_update_template_not_found'] = 'Не найден файл шаблона обновления';
    $L['install_ver'] = 'Информация о сервере';
    $L['install_ver_invalid'] = '{$ver} &mdash; неудачно!';
    $L['install_ver_valid'] = '{$ver} &mdash; успешно!';
    $L['install_view_site'] = 'Открыть сайт';
    $L['install_writable'] = 'Доступно';
}
