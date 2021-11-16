<?php

/**
 * Вывод Админпанели.
 *
 * @author NikWebit <https://cotont.ru/contact>
 * @copyright (c) Cotont CMS <https://cotont.ru>
 * @license https://github.com/NikWebit/Cotont/blob/master/LICENCE BSD-3-Clause
 */
define('COT_CODE', TRUE);
define('COT_ADMIN', TRUE);
define('COT_CORE', TRUE);

require_once './datas/configs/config.php';
require_once $cfg['system_dir'] . '/functions.php';

$env['ext'] = 'admin';
$env['type'] = 'core';
$env['location'] = 'administration';

require_once $cfg['system_dir'] . '/cotemplate.php';
require_once $cfg['system_dir'] . '/common.php';

require_once cot_incfile('admin', 'module');

include cot_incfile('admin', 'module', 'main');
