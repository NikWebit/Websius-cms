<?php

/**
 * Установщик: обновление ядра и приложений.
 *
 * @package Install
 * @author NikWebit <https://websius.ru/contact>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @copyright (c) Вебсиус | Websius CMS <https://websius.ru>
 */
if (defined('WEBSIUS') && defined('WE_UPDATE')) {

    $patch_dir = WE_PATH['cfg'] . _DS . 'setup' . _DS . 'patches';

    if (is_null($db) || !$patch_dir) {
        cot_message($L['install_dir_not_found']);
        goto NoUpdate;
    } else {
        $cfg['customfuncs'] = false;
        $cfg['cache'] = false;
        $cfg['xtpl_cache'] = false;
    }

    require_once cot_incfile('forms');
    require_once cot_incfile('extensions');

    require_once cot_langfile('install', 'module');
    require_once cot_incfile('install', 'module', 'resources');

    $out['meta_lastmod'] = gmdate('D, d M Y H:i:s');

    $cfgs_file = array_merge(
            $cfgs_file, [
        'cfg_proto' => WE_PATH['cfg'] .
        _DS . 'prototype' . _DS . "proto__$cfgname.php",
        'cfg_install' => WE_PATH['cfg'] . _DS . "updater__$cfgname.php",
        'cfg_sql' => WE_PATH['cfg'] . _DS . 'setup' . _DS . "install.sql",
    ]);

    $mskin = cot_tplfile('install.update');
    if (!file_exists($mskin)) {
        cot_diefatal($L['install_update_template_not_found']);
    }
    $t = new XTemplate($mskin);

// Проверка новых опций конфига
    if (is_file($cfgs_file['cfg']) && is_file($cfgs_file['cfg_proto'])) {

        is_writable($cfgs_file['cfg']) or
                chmod($cfgs_file['cfg'], WE_CHMOD['wfile']);

        $cot_get_config = function ($cfg_name) use ($cfg, $cfgs_file): array {
            if (in_array($cfg_name, ['cfg', 'cfg_proto'])) {
                include $cfgs_file[$cfg_name];
                $db_vars = [];
                $vars = get_defined_vars();
                foreach ($vars as $key => $val) {
                    if (preg_match('#^db_#', $key)) {
                        $db_vars[$key] = $val;
                    }
                }
            }
            return [cot::$cfg, $db_vars];
        };

        $updated_config = false;
        list($old_cfg, $old_db) = $cot_get_config('cfg');
        list($new_cfg, $new_db) = $cot_get_config('cfg_proto');

        $diff_db = array_diff_assoc_recursive($new_db, $old_db);
        $diff_cfg = array_diff_assoc_recursive($new_cfg, $old_cfg);

        if ((is_countable($diff_cfg) && count($diff_cfg) > 0) ||
                (is_countable($diff_db) && count($diff_db) > 0)) {

            // Добавление новых опций конфига
            $delta = '';
            if (count($diff_cfg) > 0) {
                foreach ($new_cfg as $key => $val) {
                    if (!isset($old_cfg[$key])) {
                        if ($key === 'site_id' || $key === 'secret_key') {
                            $val = cot_unique(32);
                        }

                        if (is_bool($val)) {
                            $val = $val ? 'TRUE' : 'FALSE';
                        } elseif (is_int($val) || is_float($val)) {
                            $val = (string) $val;
                        } else {
                            $val = "'$val'";
                        }
                        $delta .= "\$cfg['$key'] = $val;\n";
                    }
                }
            }
            if (count($diff_db) > 0) {
                foreach ($new_db as $key => $val) {
                    if (!isset($old_db[$key])) {
                        $val = str_replace("cot_", "\$db_x.'", $val);
                        $delta .= "\${$key} = $val';\n";
                    }
                }
            }
            if (!empty($delta)) {
                $config_contents = file_get_contents($cfgs_file['cfg']);
                $config_contents .= $delta;

                file_put_contents($cfgs_file['cfg'], $config_contents);
                cot_message('install_update_config_success');
                $updated_config = true;
                include $cfgs_file['cfg'];
            }
        }
    } else {
        cot_error('install_update_config_error');
    }

    $cfg['customfuncs'] = false;

    if (!cot_error_found()) {

        // Обновление ядра
        $sql_install = $db->query("SELECT upd_value FROM $db_updates WHERE upd_param = 'revision'");
        $upd_rev = $sql_install->fetchColumn();

        $rev = $upd_rev;
        $new_rev = cot_apply_patches($patch_dir, $rev);

        // Обновление установленных приложений
        $updated_ext = false;
        if (is_countable($cot_modules) && count($cot_modules) > 0) {
            foreach ($cot_modules as $code => $mod) {
                $ret = cot_extension_install($code, true, true);
                if ($ret === true) {
                    $updated_ext = true;
                } elseif ($ret === false) {
                    cot_error(cot_rc('ext_update_error', array(
                        'type' => $L['Module'],
                        'name' => $code
                    )));
                }
            }
        }
        if (is_countable($cot_plugins_enabled) &&
                count($cot_plugins_enabled) > 0) {
            foreach ($cot_plugins_enabled as $code => $plug) {
                $ret = cot_extension_install($code, false, true);
                if ($ret === true) {
                    $updated_ext = true;
                } elseif ($ret === false) {
                    cot_error(cot_rc('ext_update_error', array(
                        'type' => $L['Plugin'],
                        'name' => $code
                    )));
                }
            }
        }

        if ($new_rev === false || cot_error_found()) {

            // Вывод сообщений об ошибке
            $t->assign('UPDATE_TITLE', $L['install_update_error']);
        } elseif ($new_rev === true && !$updated_config && !$updated_ext) {
            $t->assign('UPDATE_TITLE', $L['install_update_nothing']);
            $t->assign('UPDATE_COMPLETED_NOTE', '');
            $t->parse('MAIN.COMPLETED');
        } else {
            if ($new_rev === true) {
                $new_rev = $rev;
            } else {
                $db->update($db_updates, [
                    'upd_value' => $new_rev
                        ], "upd_param = 'revision'");
            }
            $t->assign('UPDATE_TITLE', cot_rc('install_update_success',
                            ['rev' => $new_rev]));
            $t->assign('UPDATE_COMPLETED_NOTE', $L['install_complete_note']);
            $t->parse('MAIN.COMPLETED');
        }

        $t->assign(array(
            'UPDATE_FROM' => $rev,
            'UPDATE_TO' => is_string($new_rev) ? $new_rev : $rev
        ));

        // Очистка кеша
        $db->query("TRUNCATE TABLE $db_cache");
    }

    cot_display_messages($t);

    if (is_writable($cfgs_file['cfg'])) {
        chmod($cfgs_file['cfg'], WE_CHMOD['file']);
    }

    $t->parse('MAIN');
    $t->out('MAIN');
}
NoUpdate:
