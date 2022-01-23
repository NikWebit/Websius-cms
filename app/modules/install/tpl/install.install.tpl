<!-- BEGIN: MAIN -->
<!DOCTYPE html>
<html lang="{PHP.cfg.defaultlang}" xml:lang="{PHP.cfg.defaultlang}">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#cfeeff">
        <title>{PHP.L.install_title}</title>
        <meta name="generator" content="Websius CMS (Вебсиус) https://websius.ru">
        <meta http-equiv="expires" content="Fri, Apr 01 1974 00:00:00 GMT">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="cache-control" content="no-cache">
        <meta http-equiv="last-modified" content="{PHP.meta_lastmod} GMT">
        <meta name="robots" content="noindex">
        <link rel="shortcut icon" href="favicon.ico">

        <link rel="stylesheet" type="text/css" href="{PHP.cotUrl.mod}/install/tpl/style.css">
    </head>

    <body>
        <div id="box">
            <div id="header">
                {PHP.L.install_body_title} {PHP.cfg.version}
                <span>{INSTALL_STEP}</span>
            </div>

            <div id="content">
                {FILE "{PHP.cotPath.skins}/{PHP.cfg.defaulttheme}/warnings.tpl"}

                <form action="{PHP.sys.abs_url}" method="post">

                    <!-- BEGIN: STEP_0 -->

                    <ul>
                        <li><label>{PHP.L.Language}</label> {INSTALL_LANG}</li>
                        <!-- BEGIN: SCRIPT -->
                        <li><label>Install script</label> {INSTALL_SCRIPT}</li>
                        <!-- END: SCRIPT -->
                    </ul>

                    <button type="submit" name="step" value="1">{PHP.L.Next}</button>
                    <!-- END: STEP_0 -->

                    <!-- BEGIN: STEP_1 -->


                    <p>{PHP.L.install_body_message1}</p>

                    <ul class="step_1">
                        <li class="title">{PHP.L.install_ver}</li>
                        <li><strong class="php">PHP</strong> {INSTALL_PHP_VER}</li>
                        <li><strong class="mbstring">mbstring</strong> {INSTALL_MBSTRING}</li>
                        <li><strong class="mbstring">hash</strong> {INSTALL_HASH}</li>
                        <li><strong class="mysql">MySQL</strong> {INSTALL_MYSQL}</li>
                    </ul>

<!-- IF {INSTALL_CONFIG|strip_tags} != {PHP.L.install_writable} -->
                    <p>{PHP.L.install_body_message2}</p>
<!-- ENDIF -->
                    <ul class="step_1">
                        <li class="title">{PHP.L.install_permissions}</li>
                        <li><strong class="file" title="{PHP.L.File}">{INSTALL_SQL_FILE_NAME}</strong> {INSTALL_SQL_FILE}</li>
                        <li><strong class="file" title="{PHP.L.File}">{INSTALL_CONFIG_PROTO_NAME}</strong> {INSTALL_CONFIG_PROTO}</li>
                        <li><strong class="file" title="{PHP.L.File}">{INSTALL_CONFIG_NAME}</strong> {INSTALL_CONFIG}</li>

                        <li><strong class="folder" title="{PHP.L.Folder}">{PHP.cotUrl.cache}</strong> {INSTALL_CACHE_DIR}</li>
                        <li><strong class="folder" title="{PHP.L.Folder}">{PHP.cotUrl.avatars}</strong> {INSTALL_AV_DIR}</li>
                        <li><strong class="folder" title="{PHP.L.Folder}">{PHP.cotUrl.exflds}</strong> {INSTALL_EXFLDS_DIR}</li>
                        <li><strong class="folder" title="{PHP.L.Folder}">{PHP.cotUrl.pfs}</strong> {INSTALL_PFS_DIR}</li>
                        <li><strong class="folder" title="{PHP.L.Folder}">{PHP.cotUrl.photos}</strong> {INSTALL_PHOTOS_DIR}</li>
                        <li><strong class="folder" title="{PHP.L.Folder}">{PHP.cotUrl.thumbs}</strong> {INSTALL_THUMBS_DIR}</li>
                    </ul>
                    <button type="submit" name="step" value="0">{PHP.L.Back}</button>
                    <button type="submit" name="step" value="2">{PHP.L.Next}</button>
                    <!-- END: STEP_1 -->

                    <!-- BEGIN: STEP_2 -->

                    <ul>
                        <li class="title">{PHP.L.install_db}</li>
                        <li><label>{PHP.L.install_db_host}</label>  {INSTALL_DB_HOST_INPUT}</li>
                        <li><label>{PHP.L.install_db_port}</label>  {INSTALL_DB_PORT_INPUT}<div style="text-align:center;margin:3px 0"><small>{PHP.L.install_db_port_hint}</small></div></li>
                        <li><label>{PHP.L.install_db_user}</label> {INSTALL_DB_USER_INPUT}</li>
                        <li><label>{PHP.L.install_db_pass}</label> {INSTALL_DB_PASS_INPUT}</li>
                        <li><label>{PHP.L.install_db_name}</label>  {INSTALL_DB_NAME_INPUT}</li>
                        <li><label>{PHP.L.install_db_x}</label> {INSTALL_DB_X_INPUT}</li>
                    </ul>

                    <p>{PHP.L.install_body_message3}</p>

                    <button type="submit" name="step" value="1">{PHP.L.Back}</button>
                    <button type="submit" name="step" value="3">{PHP.L.Next}</button>

                    <!-- END: STEP_2 -->

                    <!-- BEGIN: STEP_3 -->

                    <ul>
                        <li class="title"><span class="settings">{PHP.L.install_misc}</span></li>
                        <li><label>{PHP.L.install_misc_theme}</label> {INSTALL_THEME_SELECT}</li>
                        <li><label>{PHP.L.install_misc_lng}</label> {INSTALL_LANG_SELECT}</li>
                        <li><label>{PHP.L.install_misc_url}</label> {INSTALL_MAINURL}</li>
                    </ul>

                    <ul>
                        <li class="title"><span class="administrator">{PHP.L.install_adminacc}</span></li>
                        <li><label>{PHP.L.Username}</label>  {INSTALL_USERNAME}</li>
                        <li><label>{PHP.L.Password}</label> {INSTALL_PASS1}</li>
                        <li><label>{PHP.L.install_retype_password}</label> {INSTALL_PASS2}</li>
                        <li><label>{PHP.L.Email}</label> {INSTALL_EMAIL}</li>
                    </ul>

                    <button type="submit" name="step" value="4">{PHP.L.Install}</button>
                    <!-- END: STEP_3 -->

                    <!-- BEGIN: STEP_4 -->

                    <ul class="step_4">
                        <li class="title">
                            <span class="modules">{PHP.L.Modules}</span>
                        </li>
                        <!-- BEGIN: MODULE_ROW -->
                        <li>
                            {MODULE_ROW_CHECKBOX}
                            <strong>{MODULE_ROW_TITLE}</strong>
                            <p>{MODULE_ROW_DESCRIPTION}</p>
                            {MODULE_ROW_REQUIRES}
                            {MODULE_ROW_RECOMMENDS}
                        </li>
                        <!-- END: MODULE_ROW -->
                    </ul>
                    <ul class="step_4">
                        <li class="title">
                            <span class="plugins">{PHP.L.Plugins}</span>
                        </li>
                        <!-- BEGIN: PLUG_CAT -->
                        <li class="extcat">{PLUG_CAT_TITLE}</li>
                        <!-- BEGIN: PLUG_ROW -->
                        <li>
                            {PLUG_ROW_CHECKBOX}
                            <strong>{PLUG_ROW_TITLE}</strong>
                            <p>{PLUG_ROW_DESCRIPTION}</p>
                            {PLUG_ROW_REQUIRES}
                            {PLUG_ROW_RECOMMENDS}
                        </li>
                        <!-- END: PLUG_ROW -->
                        <!-- END: PLUG_CAT -->
                    </ul>
                    <button type="submit" name="step" value="5">{PHP.L.Finish}</button>

                    <!-- END: STEP_4 -->

                    <!-- BEGIN: STEP_5 -->
                    <p class="complete">
                        <strong>{PHP.L.install_complete}</strong>
                        <span>{PHP.L.install_complete_note}</span>

                        <a href="{PHP.cfg.mainurl}">{PHP.L.install_view_site}</a>
                    </p>
                    <!-- END: STEP_5 -->
                </form>
            </div>
        </div>
    </body>
</html>
<!-- END: MAIN -->
