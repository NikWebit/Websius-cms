<?php

/**
 * Установщик ядра и приложений.
 *
 * @package Install
 * @author NikWebit <https://websius.ru/contact>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @copyright (c) Вебсиус | Websius CMS <https://websius.ru>
 */
(defined('WEBSIUS') && defined('WE_INSTALL')) or die('Wrong URL');

$env['location'] = 'install';
$env['ext'] = 'install';

require_once cot_incfile('forms');
require_once cot_incfile('extensions');

require_once cot_langfile('install', 'module');
require_once cot_incfile('install', 'module', 'resources');

$out['meta_lastmod'] = gmdate('D, d M Y H:i:s');

if (empty($_SESSION['cot_inst_lang'])) {
    $lang = cot_import('lang', 'P', 'ALP');
    if (empty($lang)) {
        $lang = cot_lang_determine();
    }
} else {
    $lang = $_SESSION['cot_inst_lang'];
}

/* Приложения включенные в установку по умолчанию */
$default_modules = ['index', 'page', 'users', 'rss'];
$default_plugins = ['ckeditor', 'cleaner', 'html',
    'htmlpurifier', 'ipsearch', 'search'];

$cfg['msg_separate'] = true;

$mskin = cot_tplfile('install.install');

if (!empty($_SESSION['cot_inst_script']) &&
        file_exists($_SESSION['cot_inst_script'])
) {
    require_once $_SESSION['cot_inst_script'];
}

cot_sendheaders();

$t = new XTemplate($mskin);

$sys['site_uri'] ??= _S;
$sys['domain'] ??= preg_replace(
        '#^www\.#', '', parse_url($SERV['HTTP_HOST'])['host']
);
$sys['abs_url'] = $site_url . '/';

define('WE_ABSOLUTE_URL', $sys['abs_url']);

if (filter_has_var(INPUT_POST, 'step')) {
    $step = (int) filter_input(INPUT_POST, 'step', FILTER_SANITIZE_NUMBER_INT);
} else {
    $step = 0;
}

/**
 * Динамическая замена значений конфигурации по мере установки.
 *
 * @param string $file_contents Контент (содержимое) файла конфигурации.
 * @param string $config_name Имя заменяемой опции конфига (ключ).
 * @param string $config_value Значение заменяемой опции конфига (для ключа).
 */
$cot_install_config_replace = function (
        &$file_contents, $config_name, $config_value
): void {
    $file_contents = preg_replace("#^\\\$cfg\['$config_name'\]\s*=\s*'.*?';#m",
            "\$cfg['$config_name'] = '$config_value';", $file_contents);
};

/**
 * Парсер выбранных приложений.
 *
 * @param string $ext_type Тип приложения: модуль или плагин,
 * (WE_TYPE['mod'] or WE_TYPE['plug']).
 * @param array $default_list Список рекомендуемых приложений (по умолчанию).
 * @param array $selected_list Список выбранных через опции формы приложений.
 */
$cot_install_parse_extensions = function (
        $ext_type, $default_list = [], $selected_list = []
) use ($t, $L): void {
    $ext_type_lc = strtolower($ext_type);
    $ext_type_uc = strtoupper($ext_type);

    $ext_list = cot_extension_list_info(WE_PATH[WE_TYPE_FLIP[$ext_type]]);
    $ext_type_lc == WE_TYPE['plug'] ?
            uasort($ext_list, 'cot_extension_catcmp') : ksort($ext_list);

    $prev_cat = '';
    $block_name = $ext_type_lc == WE_TYPE['plug'] ?
            "{$ext_type_uc}_CAT.{$ext_type_uc}_ROW" : "{$ext_type_uc}_ROW";

    foreach ($ext_list as $f => $info) {
        if (is_array($info)) {
            $code = $f;
            if ($ext_type_lc == WE_TYPE['plug'] &&
                    $prev_cat != $info['Category']) {
                if ($prev_cat != '') {

                    $t->parse("MAIN.STEP_4.{$ext_type_uc}_CAT");
                }

                $prev_cat = $info['Category'];
                $t->assign($ext_type_uc . '_CAT_TITLE',
                        $L['ext_cat_' . $info['Category']]);
            }
            if (!empty($info['Requires_modules']) ||
                    !empty($info['Requires_plugins'])) {

                $modules_list = empty($info['Requires_modules']) ?
                        $L['None'] :
                        implode(', ', explode(',', $info['Requires_modules']));

                $plugins_list = empty($info['Requires_plugins']) ?
                        $L['None'] :
                        implode(', ', explode(',', $info['Requires_plugins']));

                $requires = cot_rc('install_code_requires',
                        ['modules_list' => $modules_list,
                            'plugins_list' => $plugins_list]
                );
            } else {
                $requires = '';
            }

            if (!empty($info['Recommends_modules']) ||
                    !empty($info['Recommends_plugins'])) {

                $modules_list = empty($info['Recommends_modules']) ?
                        $L['None'] :
                        implode(', ', explode(',', $info['Recommends_modules']));

                $plugins_list = empty($info['Recommends_plugins']) ?
                        $L['None'] :
                        implode(', ', explode(',', $info['Recommends_plugins']));

                $recommends = cot_rc('install_code_recommends',
                        [
                            'modules_list' => $modules_list,
                            'plugins_list' => $plugins_list
                ]);
            } else {
                $recommends = '';
            }

            if ((is_array($selected_list) && count($selected_list)) > 0) {
                $checked = in_array($code, $selected_list);
            } else {
                $checked = in_array($code, $default_list);
            }

            $L['info_name'] = '';
            $L['info_desc'] = '';
            if (file_exists(PathX::langFile($code, $ext_type))) {

                include_once Path::langFile($code, $ext_type);
            }

            $t->assign([
                "{$ext_type_uc}_ROW_CHECKBOX" => cot_checkbox($checked, "install_{$ext_type_lc}s[$code]"),
                "{$ext_type_uc}_ROW_TITLE" => empty($L['info_name']) ? $info['Name'] : $L['info_name'],
                "{$ext_type_uc}_ROW_DESCRIPTION" => empty($L['info_desc']) ? $info['Description'] : $L['info_desc'],
                "{$ext_type_uc}_ROW_REQUIRES" => $requires,
                "{$ext_type_uc}_ROW_RECOMMENDS" => $recommends
            ]);
            $t->parse("MAIN.STEP_4.$block_name");
        }
    }

    if ($ext_type_lc == WE_TYPE['plug'] && $prev_cat != '') {
        $t->parse("MAIN.STEP_4.{$ext_type_uc}_CAT");
    }
};

/**
 * Сортировка выбранных приложений если указан параметр order в файлах.
 *
 * @param array  $selected_extensions Неотсортированный список приложений.
 * @param bool   $is_module Тип приложения: TRUE если модуль, иначе FALSE.
 * @return array Отсортированный список приложений.
 */
$cot_install_sort_extensions = function (
        $selected_extensions, $is_module = FALSE
): array {

    $path = $is_module ? WE_PATH['mod'] : WE_PATH['plug'];
    $ret = array();

    // Объединение в группы по значениям.
    $extensions = [];
    foreach ($selected_extensions as $name) {
        $info = cot_infoget("$path/$name/$name.setup.php", 'WE_EXT');
        $order = isset($info['Order']) ?
                (int) $info['Order'] : WE_PLUGIN_DEFAULT_ORDER;

        if (isset($info['Category']) &&
                $info['Category'] == 'post-install' && $order < 999) {
            $order = 999;
        }
        $extensions[$order][] = $name;
    }

    // Объединение в единый массив.
    foreach ($extensions as $grp) {
        foreach ($grp as $name) {
            $ret[] = $name;
        }
    }

    return $ret;
};

/* УСТАНОВКА */

// Импорт значений.
switch ($step) {

    case 3:
        $db_host = cot_import('db_host', 'P', 'TXT', 0, false, true);
        $db_port = cot_import('db_port', 'P', 'TXT', 0, false, true);
        $db_user = cot_import('db_user', 'P', 'TXT', 0, false, true);
        $db_pass = cot_import('db_pass', 'P', 'TXT', 0, false, true);
        $db_name = cot_import('db_name', 'P', 'TXT', 0, false, true);
        break;

    case 4:
        $rurl = cot_import('mainurl', 'P', 'TXT', 0, false, true);
        $user['name'] = cot_import('user_name', 'P', 'TXT', 100, false, true);
        $user['pass'] = cot_import('user_pass', 'P', 'TXT', 32);
        $user['pass2'] = cot_import('user_pass2', 'P', 'TXT', 32);
        $user['email'] = cot_import('user_email', 'P', 'TXT', 64, false, true);
        $user['country'] = cot_import('user_country', 'P', 'TXT', 0, false, true);
        $rtheme = explode(':', cot_import('theme', 'P', 'TXT', 0, false, true));
        $rscheme = isset($rtheme[1]) ? $rtheme[1] : $cfg['defaultscheme'];
        $rtheme = $rtheme[0];
        $rlang = cot_import('lang', 'P', 'TXT', 0, false, true);
        break;

    case 5:
// Выбор приложений
        $install_modules = cot_import('install_modules', 'P', 'ARR', 0, false, true);
        $selected_modules = [];
        if (is_array($install_modules)) {
            foreach ($install_modules as $key => $val) {
                if ($val) {
                    $selected_modules[] = $key;
                }
            }
        }
        $install_plugins = cot_import('install_plugs', 'P', 'ARR', 0, false, true);
        $selected_plugins = [];
        if (is_array($install_plugins)) {
            foreach ($install_plugins as $key => $val) {
                if ($val) {
                    $selected_plugins[] = $key;
                }
            }
        }
        break;
}

if ($step > 3) {
    if (is_null($db)) {

        include $cfgs_file['cfg_install'];
        $db = CotDB::connect('mysql');
        $db->registerCoreTables();
        cot::init();
    }
}

$inst_func_name = "cot_install_step" . $step . "_import";
function_exists($inst_func_name) && $inst_func_name();

if ($SERV['REQUEST_METHOD'] === 'POST') {

    switch ($step) {
        case 0:
// Настройки языка
            $_SESSION['cot_inst_lang'] = $lang;
            $_SESSION['cot_inst_script'] = cot_import('script', 'P', 'TXT');
            break;

        case 1:
            clearstatcache();
            if (!file_exists($cfgs_file['cfg_sql'])) {
                cot_error(cot_rc('install_error_missing_file',
                                ['file' => $cfgs_file['cfg_sql']]
                ));
            }
            break;
        case 2:
            break;

        case 3:
// Настройки БД
            $db_x = cot_import('db_x', 'P', 'TXT', 0, false, true);

            if (empty($db_host)) {
                cot_error('install_error_sql_host', 'db_host');
            }
            if (empty($db_user)) {
                cot_error('install_error_sql_user', 'db_user');
            }
            if (empty($db_name)) {
                cot_error('install_error_sql_db_name', 'db_name');
            }

            if (!cot_error_found()) {

                clearstatcache();
                cot::init();

                $config_contents = file_get_contents($cfgs_file['cfg_install']);
                $cot_install_config_replace($config_contents, 'mysqlhost', $db_host);
                if (!empty($db_port)) {
                    $cot_install_config_replace($config_contents, 'mysqlport', $db_port);
                }
                $cot_install_config_replace($config_contents, 'mysqluser', $db_user);
                $cot_install_config_replace($config_contents, 'mysqlpassword', $db_pass);
                $cot_install_config_replace($config_contents, 'mysqldb', $db_name);

                $put_config_contents = preg_replace("#^\\\$db_x\s*=\s*'.*?';#m", "\$db_x = '$db_x';", $config_contents);

                file_put_contents($cfgs_file['cfg_install'], $put_config_contents);

                try {

                    include $cfgs_file['cfg_install'];
                    $db = CotDB::connect('mysql');
                } catch (PDOException $e) {

                    if ($e->getCode() === 1049 || mb_strpos($e->getMessage(), '[1049]') !== false) {

                        try {

                            $dbc_port = empty($db_port) ?
                                    '' : ';port=' . $db_port;

                            $db = new CotDB(
                                    'mysql:host=' . $db_host .
                                    $dbc_port, $db_user, $db_pass
                            );

                            $db->query("CREATE DATABASE `$db_name`");
                            $db->query("USE `$db_name`");
                        } catch (PDOException $e) {

                            cot_error('install_error_sql_db', 'db_name');
                        }
                    } else {
                        cot_error('install_error_sql', 'db_host');
                    }
                }

                if (is_null($db)) {
                    cot_error('install_error_sql_db', 'db_name');
                } else {

                    $has_tables = $db->query('SHOW TABLES');
                    $drop_tables = [];

                    while ($row = $has_tables->fetch()) {

                        $tb_key = key($row);

                        if (is_array($row) && !empty($tb_key)) {
                            $drop_tables[] = "`{$row[$tb_key]}`";
                        }
                    }

                    $has_tables->closeCursor();

                    if (is_countable($drop_tables) && count($drop_tables) > 0) {

                        $drop_tables_sql = 'DROP TABLE ' .
                                implode(',', $drop_tables);
                        $db->query($drop_tables_sql);
                    }
                }
            }

            if (!cot_error_found()) {
                cot::init();

                $config_contents = file_get_contents($cfgs_file['cfg_install']);
                $cot_install_config_replace($config_contents, 'mysqlhost', $db_host);
                if (!empty($db_port)) {
                    $cot_install_config_replace($config_contents, 'mysqlport', $db_port);
                }
                $cot_install_config_replace($config_contents, 'mysqluser', $db_user);
                $cot_install_config_replace($config_contents, 'mysqlpassword', $db_pass);
                $cot_install_config_replace($config_contents, 'mysqldb', $db_name);

                $put_config_contents = preg_replace("#^\\\$db_x\s*=\s*'.*?';#m", "\$db_x = '$db_x';", $config_contents);

                file_put_contents($cfgs_file['cfg_install'], $put_config_contents);

                $sql_file = file_get_contents($cfgs_file['cfg_sql']);

                $error = $db->runScript($sql_file);

                if ($error) {
                    cot_error(
                            cot_rc('install_error_sql_script',
                                    ['msg' => $error]
                            )
                    );
                }
            }
            break;

        case 4:
// Проверка настроек и параметров Админа
            if (empty($rurl)) {
                cot_error('install_error_mainurl', 'mainurl');
            }
            if ($user['pass'] != $user['pass2']) {
                cot_error('aut_passwordmismatch', 'user_pass');
            }
            if (mb_strlen($user['name']) < 2) {
                cot_error('aut_usernametooshort', 'user_name');
            }
            if (mb_strlen($user['pass']) < 4) {
                cot_error('aut_passwordtooshort', 'user_pass');
            }
            if (mb_strlen($user['email']) < 4 || !cot_check_email($user['email'])) {
                cot_error('aut_emailtooshort', 'user_email');
            }
            if (!file_exists($cfgs_file['cfg_proto'])) {
                cot_error(cot_rc('install_error_missing_file', array('file' => $cfgs_file['cfg_proto'])));
            }

            if (!cot_error_found()) {
                $config_contents = file_get_contents($cfgs_file['cfg_install']);
                $cot_install_config_replace($config_contents, 'defaultlang', $rlang);
                $cot_install_config_replace($config_contents, 'defaulttheme', $rtheme);
                $cot_install_config_replace($config_contents, 'defaultscheme', $rscheme);
                $cot_install_config_replace($config_contents, 'mainurl', $rurl);

                $new_site_id = cot_unique(32);
                $cot_install_config_replace($config_contents, 'site_id', $new_site_id);
                $new_secret_key = cot_unique(32);
                $cot_install_config_replace($config_contents, 'secret_key', $new_secret_key);

                file_put_contents($cfgs_file['cfg_install'], $config_contents);

                $ruserpass['user_passsalt'] = cot_unique(16);
                $ruserpass['user_passfunc'] = empty($cfg['hashfunc']) ? 'sha256' : $cfg['hashfunc'];
                $ruserpass['user_password'] = cot_hash($user['pass'], $ruserpass['user_passsalt'], $ruserpass['user_passfunc']);

                try {
                    $db->insert($db_x . 'users', array(
                        'user_name' => $user['name'],
                        'user_password' => $ruserpass['user_password'],
                        'user_passsalt' => $ruserpass['user_passsalt'],
                        'user_passfunc' => $ruserpass['user_passfunc'],
                        'user_maingrp' => WE_GROUP_SUPERADMINS,
                        'user_country' => (string) $user['country'],
                        'user_email' => $user['email'],
                        'user_theme' => $rtheme,
                        'user_scheme' => $rscheme,
                        'user_lang' => $rlang,
                        'user_regdate' => time(),
                        'user_lastip' => $SERV['REMOTE_ADDR']
                    ));

                    $user['id'] = $db->lastInsertId();

                    $db->insert($db_x . 'groups_users', array(
                        'gru_userid' => (int) $user['id'],
                        'gru_groupid' => WE_GROUP_SUPERADMINS
                    ));

                    $db->update($db_x . 'config', array('config_value' => $user['email']), "config_owner = 'core' AND config_name = 'adminemail'");
                } catch (PDOException $err) {
                    cot_error(cot_rc('install_error_sql_script', array('msg' => $err->getMessage())));
                }
            }
            break;
        case 5:

// Проверка зависимостей
            $install = true;
            foreach ($selected_modules as $ext) {
                $install &= cot_extension_dependencies_statisfied($ext, true, $selected_modules, $selected_plugins);
            }
            foreach ($selected_plugins as $ext) {
                $install &= cot_extension_dependencies_statisfied($ext, false, $selected_modules, $selected_plugins);
            }

            if ($install && !cot_error_found()) {
// Загрузка групп

                $cot_groups = [];

                $res = $db->query("SELECT * FROM {$db_x}groups WHERE grp_disabled=0 ORDER BY grp_level DESC");

                while ($row = $res->fetch()) {
                    $cot_groups[$row['grp_id']] = array(
                        'id' => $row['grp_id'],
                        'alias' => $row['grp_alias'],
                        'level' => $row['grp_level'],
                        'disabled' => $row['grp_disabled'],
                        'name' => htmlspecialchars($row['grp_name']),
                        'title' => htmlspecialchars($row['grp_title'])
                    );
                }
                $res->closeCursor();
                $usr['id'] = 1;
// Установка в один момент
// Важно: статус установки игнорируется в этом инсталляторе
                $selected_modules = $cot_install_sort_extensions($selected_modules, true);
                foreach ($selected_modules as $ext) {
                    if (!cot_extension_install($ext, true)) {
                        cot_error("Installing $ext " . WE_TYPE['mod'] . " has failed");
                    }
                }
                $selected_plugins = $cot_install_sort_extensions($selected_plugins, false);
                foreach ($selected_plugins as $ext) {
                    if (!cot_extension_install($ext, false)) {
                        cot_error("Installing $ext " . WE_TYPE['plug'] . " has failed");
                    }
                }
            }
            break;

        default:
// Ошибка
            cot_redirect($sys['site_uri']);
            exit;
    }

    $inst_func_name = "cot_install_step" . $step . "_setup";
    function_exists($inst_func_name) && $inst_func_name();

    if (cot_error_found()) {

        cot_redirect($sys['site_uri']);
    } else {

        $config_contents = file_get_contents($cfgs_file['cfg_install']);

        function_exists("cot_install_stepplusplus") && cot_install_stepplusplus();

        file_put_contents($cfgs_file['cfg_install'], $config_contents);

        if ($step === 5) {
            rename($cfgs_file['cfg_install'], $cfgs_file['cfg']);
            chmod($cfgs_file['cfg'], WE_CHMOD['file']);
        }
    }
}

// Отображение
switch ($step) {
    case 0:
// Выбор языка
        $t->assign([
            'INSTALL_LANG' => cot_selectbox_lang($lang, 'lang')
        ]);

        $install_files = glob("*.install.php");

        if (!empty($install_files)) {
            $install_scripts = array();
            foreach ($install_files as $filename) {
                preg_match("#(.*?)\/?(.+)\.install\.php#i", $filename, $mtch);
                $install_scripts[$filename] = $mtch[2];
            }
            $t->assign(array(
                'INSTALL_SCRIPT' => cot_selectbox('', 'script', array_keys($install_scripts), array_values($install_scripts))
            ));
            $t->parse("MAIN.STEP_$step.SCRIPT");
        }
        break;

    case 1:
        /**
         * Проверка подпапок кеша, и создание если отсутствуют.
         */
        if (is_writable(WE_PATH['cache'])) {
            $cache_subfolders = array('cot', 'static', 'system', 'templates');
            foreach ($cache_subfolders as $sub) {
                if (!file_exists(WE_PATH['cache'] . '/' . $sub)) {
                    mkdir(WE_PATH['cache'] . '/' . $sub, WE_CHMOD['wdir']);
                }
            }
        }

        /**
         * Проверка директорий, прав, нужных расширений на сервере.
         */
        clearstatcache();

        $test_dirs = ['cache', 'avatars', 'pfs', 'exflds', 'photos', 'thumbs'];

        foreach ($test_dirs as $dir) {
            if (is_dir(WE_PATH[$dir])) {
                $status[$dir . '_dir'] = is_writable(WE_PATH[$dir]) ?
                        $R['install_code_writable'] :
                        cot_rc('install_code_invalid', [
                            'text' =>
                            cot_rc('install_chmod_value',
                                    ['chmod' =>
                                        substr(decoct(
                                                        fileperms(WE_PATH[$dir])
                                                ), -4)
                                    ])
                ]);
            } else {
                $status[$dir . '_dir'] = $R['install_code_not_found'];
            }
        }

        if (file_exists($cfgs_file['cfg_install']) || is_writable($cfgs_path)) {
            $status['config'] = is_writable($cfgs_file['cfg_install']) ||
                    is_writable($cfgs_path) ? $R['install_code_writable'] :
                    cot_rc('install_code_invalid', array('text' =>
                        cot_rc('install_chmod_value', ['chmod' =>
                            substr(decoct(
                                            fileperms($cfgs_file['cfg_install'])
                                    ), -4)
            ])));
        } else {
            $status['config'] = $R['install_code_not_found'];
        }
        /* ------------------- */
        if (file_exists($cfgs_file['cfg_proto'])) {
            $status['config_proto'] = $R['install_code_found'];
        } else {
            $status['config_proto'] = $R['install_code_not_found'];
        }
        /* ------------------- */
        if (file_exists($cfgs_file['cfg_sql'])) {
            $status['sql_file'] = $R['install_code_found'];
        } else {
            $status['sql_file'] = $R['install_code_not_found'];
        }
        $status['php_ver'] = (
                version_compare(PHP_VERSION, WEBSIUS['php-min'], '>=')
                ) ? cot_rc('install_code_valid', ['text' => cot_rc(
                            'install_ver_valid', ['ver' => PHP_VERSION]
            )]) : cot_rc('install_code_invalid', ['text' =>
                    cot_rc('install_ver_invalid', ['ver' => PHP_VERSION])]);

        $status['mbstring'] = (extension_loaded('mbstring')) ?
                $R['install_code_available'] : $R['install_code_not_available'];
        $status['hash'] = (extension_loaded('hash') &&
                function_exists('hash_hmac')) ? $R['install_code_available'] :
                $R['install_code_not_available'];
        $status['mysql'] = (extension_loaded('pdo_mysql')) ?
                $R['install_code_available'] : $R['install_code_not_available'];

        $t->assign(array(
            'INSTALL_AV_DIR' => $status['avatars_dir'],
            'INSTALL_CACHE_DIR' => $status['cache_dir'],
            'INSTALL_PFS_DIR' => $status['pfs_dir'],
            'INSTALL_EXFLDS_DIR' => $status['exflds_dir'],
            'INSTALL_PHOTOS_DIR' => $status['photos_dir'],
            'INSTALL_THUMBS_DIR' => $status['thumbs_dir'],
            'INSTALL_CONFIG' => $status['config'],
            'INSTALL_CONFIG_NAME' => basename($cfgs_file['cfg_install']),
            'INSTALL_CONFIG_PROTO' => $status['config_proto'],
            'INSTALL_CONFIG_PROTO_NAME' => basename($cfgs_file['cfg_proto']),
            'INSTALL_SQL_FILE' => $status['sql_file'],
            'INSTALL_SQL_FILE_NAME' => basename($cfgs_file['cfg_sql']),
            'INSTALL_PHP_VER' => $status['php_ver'],
            'INSTALL_MBSTRING' => $status['mbstring'],
            'INSTALL_HASH' => $status['hash'],
            'INSTALL_MYSQL' => $status['mysql'],
        ));
        break;

    case 2:

        $db_host ??= $cfg['mysqlhost'];
        $db_port ??= $cfg['mysqlport'];
        $db_user ??= $cfg['mysqluser'];
        $db_name ??= $cfg['mysqldb'];

        $t->assign(array(
            'INSTALL_DB_HOST' => $db_host,
            'INSTALL_DB_PORT' => $db_port,
            'INSTALL_DB_USER' => $db_user,
            'INSTALL_DB_NAME' => $db_name,
            'INSTALL_DB_X' => $db_x,
            'INSTALL_DB_HOST_INPUT' => cot_inputbox('text', 'db_host', $db_host, 'size="32"'),
            'INSTALL_DB_PORT_INPUT' => cot_inputbox('text', 'db_port', $db_port, 'size="32"'),
            'INSTALL_DB_USER_INPUT' => cot_inputbox('text', 'db_user', $db_user, 'size="32"'),
            'INSTALL_DB_NAME_INPUT' => cot_inputbox('text', 'db_name', $db_name, 'size="32"'),
            'INSTALL_DB_PASS_INPUT' => cot_inputbox('password', 'db_pass', '', 'size="32"'),
            'INSTALL_DB_X_INPUT' => cot_inputbox('text', 'db_x', $db_x, 'size="32"'),
        ));
        break;

    case 3:
// Настройки
        $user['name'] ??= '';
        $user['email'] ??= '';
        $user['country'] ??= '';
        $rtheme ??= WE_SKIN['user'];
        $rscheme ??= $cfg['defaultscheme'];
        $rlang ??= $lang;
        $rurl ??= $site_url;

        $t->assign(array(
            'INSTALL_THEME_SELECT' => cot_selectbox_theme($rtheme, $rscheme, 'theme'),
            'INSTALL_LANG_SELECT' => cot_selectbox_lang($rlang, 'lang'),
            'INSTALL_COUNTRY_SELECT' => cot_selectbox_countries($user['country'], 'user_country'),
            'INSTALL_MAINURL' => cot_inputbox('text', 'mainurl', rtrim($rurl, $SERV['REQUEST_URI']), 'size="32"'),
            'INSTALL_USERNAME' => cot_inputbox('text', 'user_name', $user['name'], 'size="32"'),
            'INSTALL_PASS1' => cot_inputbox('password', 'user_pass', '', 'size="32"'),
            'INSTALL_PASS2' => cot_inputbox('password', 'user_pass2', '', 'size="32"'),
            'INSTALL_EMAIL' => cot_inputbox('text', 'user_email', $user['email'], 'size="32"'),
        ));
        break;

    case 4:
// Приложения
        $selected_modules ??= '';
        $selected_plugins ??= '';

        $cot_install_parse_extensions(
                WE_TYPE['mod'], $default_modules, $selected_modules
        );

        $cot_install_parse_extensions(
                WE_TYPE['plug'], $default_plugins, $selected_plugins
        );

        break;

    case 5:
// Завершение
        break;
}

$inst_func_name = "cot_install_step" . $step . "_tags";
function_exists($inst_func_name) && $inst_func_name();

$t->parse("MAIN.STEP_$step");

// Вывод сообщений и ошибок
cot_display_messages($t);

unset(
        $cot_install_sort_extensions,
        $cot_install_config_replace,
        $cot_install_parse_extensions,
);

$t->assign(array(
    'INSTALL_STEP' => $step === 5 ? $L['Complete'] :
            cot_rc('install_step', ['step' => $step, 'total' => 4]),
    'INSTALL_LANG' => cot_selectbox_lang($lang, 'lang')
));

$t->parse('MAIN');
$t->out('MAIN');
