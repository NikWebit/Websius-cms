<?php

/** Этот файл является частью Cotont CMS ---------------------------------------

  @license BSD 3-Clause
  @copyright © NikWebit, 2021
  @link https://cotont.ru Веб-сайт Cotont CMS

  Для получения полной информации об авторских правах и условиях использования,
  смотрите файл лицензии LICENCE, который является неотъемлемой частью сборки,
  и обязательно должен присутствовать в легальном дистрибутиве Cotont CMS.
  --------------------------------------------------------------------------- */
defined('COT_CODE') or die('Wrong URL');

/* MySQL database parameters.
 * Change to fit your host.
  --------------------------------------------------------------------------- */
$cfg['mysqlhost'] = 'localhost'; // Database host URL
$cfg['mysqlport'] = '';    // Database port, if non-default
$cfg['mysqluser'] = 'root';   // Database user
$cfg['mysqlpassword'] = '';   // Database password
$cfg['mysqldb'] = 'cotonti';  // Database name
// MySQL database charset and collate. Very useful when MySQL server uses different charset rather than site
// See the list of valid values here: https://dev.mysql.com/doc/refman/8.0/en/charset-charsets.html
$cfg['mysqlcharset'] = 'utf8';
$cfg['mysqlcollate'] = 'utf8_unicode_ci';

/* Main site URL without trailing slash.
  --------------------------------------------------------------------------- */
$cfg['mainurl'] = 'http://localhost';
$cfg['site_id'] = 'Some unique string specific to your site';
$cfg['secret_key'] = 'Secret key used for authentication, make it unique and keep in secret!';
$cfg['multihost'] = false;   // Allow multiple host names for this site

/* Default theme, color scheme and default language
  --------------------------------------------------------------------------- */
$cfg['defaulttheme'] = 'nemesis'; // Default theme code. Be SURE it's pointing to a valid folder in ./themes/... !!
$cfg['defaultscheme'] = 'default'; // Default color scheme, only name, not like themename.css. Be SURE it's pointing to a valid folder in ./themes/defaulttheme/... !!
$cfg['defaulticons'] = 'default'; // Default icon pack
$cfg['defaultlang'] = 'ru';   // Default language code
$cfg['enablecustomhf'] = false;  // To enable header.$location.tpl and footer.$location.tpl
$cfg['admintheme'] = '';   // Put custom administration theme name here

/* SSL parameters and First Cookie SameSite Policy
  --------------------------------------------------------------------------- */
$cfg['ssl_port'] = '443';
$cfg['cookie_samesite'] = 'Lax';   // Lax, Strict, None or '';
$cfg['session_cookie_samesite'] = 'Lax';   // Lax, Strict, None or '';
// See the list of valid values here:
// https://php.net/function.setcookie.html  https://php.net/function.session-set-cookie-params.html

/* Performance-related settings
  --------------------------------------------------------------------------- */
$cfg['cache'] = true;   // Enable data caching
$cfg['cache_drv'] = '';   // Cache driver name to use on your server (if available)
// Possible values: APC, Memcache, Xcache
$cfg['cache_drv_host'] = 'localhost';
$cfg['cache_drv_port'] = null;

$cfg['xtpl_cache'] = true;  // Enable XTemplate structure disk cache. Should be true on production sites
$cfg['html_cleanup'] = false; // Wipe extra spaces and breaks from HTML to get smaller footprint

$cfg['cache_index'] = false;    // Static page cache for guests on index
$cfg['cache_page'] = false;     // Static page cache for guests on pages and categories
$cfg['cache_forums'] = false;   // Static page cache for guests on forums

/* More settings should work fine in most of cases.
 * If you don't know, don't change.
 * true = enabled / false = disabled
  --------------------------------------------------------------------------- */
$cfg['check_updates'] = false;  // Automatically check for updates, set it true to enable

$cfg['display_errors'] = true;  // Display error messages. Switch it false on production sites

$cfg['redirmode'] = false;   // 0 or 1, Set to '1' if you cannot sucessfully log in (IIS servers)
$cfg['xmlclient'] = false;    // For testing-purposes only, else keep it off.
$cfg['ipcheck'] = false;     // Will kill the logged-in session if the IP has changed
$cfg['authcache'] = true;   // Auth cache in SQL tables. Set it false if your huge database
// goes down because of that
$cfg['customfuncs'] = false;  // Includes file named functions.custom.php
$cfg['new_install'] = 1;   // This setting denotes a new install step and redirects you to the install page
// If you already have Cotonti installed then set it to false or remove it
$cfg['useremailduplicate'] = false;     // Allow users to register new accounts with duplicate email. DO NOT ENABLE this setting unless you know for sure that you need it or it may make your database inconsistent.

/* Directory paths.
 * Set it to custom if you want to share folders among different hosts.
  --------------------------------------------------------------------------- */
$cfg['ui_dir'] = 'ui';
$cfg['app_dir'] = 'app';
$cfg['datas_dir'] = 'datas';
$cfg['modules_dir'] = 'modules';
$cfg['plugins_dir'] = 'plugins';

$cfg['lang_dir'] = $cfg['app_dir'] . '/lang';
$cfg['system_dir'] = $cfg['app_dir'] . '/inc';
$cfg['themes_dir'] = $cfg['ui_dir'].'/themes';
$cfg['icons_dir'] = $cfg['ui_dir'].'/img/icons';

$cfg['pfs_dir'] = $cfg['datas_dir'] . '/users';
$cfg['cache_dir'] = $cfg['datas_dir'] . '/cache';
$cfg['photos_dir'] = $cfg['datas_dir'] . '/photos';
$cfg['thumbs_dir'] = $cfg['datas_dir'] . '/thumbs';
$cfg['avatars_dir'] = $cfg['datas_dir'] . '/avatars';
$cfg['extrafield_files_dir'] = $cfg['datas_dir'] . '/exflds';

/* Directory and file permissions for uploaded and created with scripts files.
 * Set it to values which deliver highest security and comfort on your host.
  --------------------------------------------------------------------------- */
$cfg['dir_perms'] = 0777;
$cfg['file_perms'] = 0664;

/* Important constant switches
 * Defines whether to display debugging information on critical errors.
 * Set it true when you experiment with something new.
 * Set it false on production sites.
  --------------------------------------------------------------------------- */
$cfg['debug_mode'] = false;

/* Path to debug log files used by functions which dump debug data into it.
 * This file MUST NOT be available to strangers (e.g. via HTTP) or it can
 * compromise your website security. Protect it with .htaccess or use some
 * path accessible to you only via FTP.
  --------------------------------------------------------------------------- */
$cfg['debug_logpath'] = 'datas/tmp';

/* The shield is disabled for administrators by default. But if you are testing
 * it with your admin account, you can enable it by setting this true.
  --------------------------------------------------------------------------- */
$cfg['shield_force'] = false;

/* Names for MySQL tables. Only change if you'd like to
 * make 2 separated installs in the same database.
 * or you'd like to share some tables between 2 sites.
 * Else do not change.
  --------------------------------------------------------------------------- */
$db_x = 'cot_'; // Default: cot_, prefix for extra fields' table(s)

// Examples:
// $db_auth			= 'my_custom_auth';
// $db_cache 		= 'my_custom_cache';
