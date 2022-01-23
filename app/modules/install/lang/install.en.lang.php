<?php

/**
 * English Language interface for installer.
 *
 * @package Install
 * @author NikWebit <https://websius.ru/contact>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @copyright (c) Вебсиус | Websius CMS <https://websius.ru>
 */
defined('WEBSIUS') or die('Wrong URL.');

if (defined('WE_INSTALL') || defined('WE_UPDATE')) {
    $L['Complete'] = 'Complete';
    $L['Finish'] = 'Finish';
    $L['Install'] = 'Install';
    $L['Next'] = 'Next';

    $L['install_adminacc'] = 'Administrator Account';
    $L['install_body_title'] = 'Websius Web Installer';

        $L['install_files_chmod'] = [
        'file' => substr(decoct(WE_CHMOD['file']),-4),
        'wfile' => substr(decoct(WE_CHMOD['wfile']),-4)
    ];

    $L['install_body_message1'] = 'This script will setup the basic Websius installation and configuration for you.';
    $L['install_body_message2'] = 'It is recommended to copy datas/configs/prototype/'.basename($cfgs_file['cfg_proto']).' to datas/configs/'.basename($cfgs_file['cfg_install']).' and set CHMOD '.$L['install_files_chmod']['wfile'].' on it before running this script.';
    $L['install_body_message3'] = 'First you need to <strong>create a blank database</strong> with the above name on your server, if this user has no permission to create new databases.';
    $L['install_chmod_value'] = 'CHMOD {$chmod}';
    $L['install_complete'] = 'Installation has been successfully completed!';
    $L['install_complete_note'] = 'You may remove install.php and set CHMOD '.$L['install_files_chmod']['file'].' on datas/configs/'.basename($cfgs_file['cfg']).' now until the next update to improve site security';
    $L['install_db'] = 'MySQL Database Settings';
    $L['install_db_host'] = 'Database host';
    $L['install_db_user'] = 'Database user';
    $L['install_db_pass'] = 'Database password';
    $L['install_db_port'] = 'Database port';
    $L['install_db_port_hint'] = 'Only if it is other than default';
    $L['install_db_name'] = 'Database name';
    $L['install_db_x'] = 'Table prefix';
    $L['install_dir_not_found'] = 'Setup directory not found';
    $L['install_error_config'] = 'Could not create or edit config file. Please save datas/configs/prototype/'.basename($cfgs_file['cfg_proto']).' as datas/configs/'.basename($cfgs_file['cfg_install']).' and set CHMOD '.$L['install_files_chmod']['wfile'].' on it';
    $L['install_error_sql'] = 'Unable to connect to MySQL database. Please check your settings.';
    $L['install_error_sql_host'] = 'Database host is missing';
    $L['install_error_sql_user'] = 'Database user is missing';
    $L['install_error_sql_db_name'] = 'Database name is missing';
    $L['install_error_sql_db'] = 'Unable to select the MySQL database. Please check your settings.';
    $L['install_error_sql_ext'] = 'Websius requires PHP extension pdo_mysql to be loaded';
    $L['install_error_sql_script'] = 'SQL script execution failed: {$msg}';
    $L['install_error_mainurl'] = 'You must supply the main URL for your site.';
    $L['install_error_mbstring'] = 'Websius requires PHP extension mbstring to be loaded';
    $L['install_error_missing_file'] = 'Missing {$file}. Please reupload this file to continue.';
    $L['install_error_php_ver'] = 'Websius requires PHP version '.WEBSIUS['php-min'].' or greater. Your version is {$ver}';
    $L['install_misc'] = 'Miscellaneous Settings';
    $L['install_misc_lng'] = 'Default language';
    $L['install_misc_theme'] = 'Default theme';
    $L['install_misc_url'] = 'Main site URL (without a trailing slash)';
    $L['install_parsing'] = 'Parsing mode';
    $L['install_parsing_hint'] = 'Parsing mode will be applied globally on your site. If you choose HTML, all existing items will be converted to HTML automatically. This operation cannot be undone.';
    $L['install_permissions'] = 'File/Folder Permissions';
    $L['install_recommends'] = 'Recommends';
    $L['install_requires'] = 'Requires';
    $L['install_retype_password'] = 'Retype password';
    $L['install_step'] = 'Step {$step} of {$total}';
    $L['install_title'] = 'Websius Web Installer';
    $L['install_update'] = 'Updating Websius';
    $L['install_update_config_error'] = 'Cannot update datas/configs/'.basename($cfgs_file['cfg']).'. Please set CHMOD '.$L['install_files_chmod']['file'].' or '.$L['install_files_chmod']['wfile'].' on it and try again. If it does not help, make sure that datas/configs/prototype/'.basename($cfgs_file['cfg_proto']).' exists.';
    $L['install_update_config_success'] = 'Successfully updated datas/configs/'.basename($cfgs_file['cfg']);
    $L['install_update_error'] = 'Update Failed';
    $L['install_update_nothing'] = 'Nothing to update';
    $L['install_update_patch_applied'] = 'Applied patch {$f}: {$msg}';
    $L['install_update_patch_error'] = 'Error applying patch {$f}: {$msg}';
    $L['install_update_patches'] = 'Applied patches:';
    $L['install_update_success'] = 'Successfully updated to revision {$rev}';
    $L['install_update_template_not_found'] = 'Update template file not found';
    $L['install_ver'] = 'Server Info';
    $L['install_ver_invalid'] = '{$ver} &mdash; invalid!';
    $L['install_ver_valid'] = '{$ver} &mdash; valid!';
    $L['install_view_site'] = 'View the site';
    $L['install_writable'] = 'Writable';
}
