<?php

/**
 * Вывод Админпанели.
 *
 * @copyright © NikWebit, 2021
 * @link https://cotont.ru Веб-сайт Cotont CMS
 * @license BSD 3-Clause https://github.com/NikWebit/Cotont/blob/master/LICENCE
 *
 * Этот файл — часть Cotont CMS. Смотрите LICENCE (также идет с дистрибутивом),
 * для получения полной информации об авторских правах и условиях использования.
  --------------------------------------------------------------------------- */
define('COT_CODE', TRUE);
define('COT_ADMIN', TRUE);
define('COT_CORE', TRUE);

require_once './datas/config.php';
require_once $cfg['system_dir'] . '/functions.php';

$env['ext'] = 'admin';
$env['type'] = 'core';
$env['location'] = 'administration';

require_once $cfg['system_dir'] . '/cotemplate.php';
require_once $cfg['system_dir'] . '/common.php';

require_once cot_incfile('admin', 'module');

include cot_incfile('admin', 'module', 'main');
