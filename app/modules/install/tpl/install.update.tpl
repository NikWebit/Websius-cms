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
                {PHP.L.install_update}
                <!-- IF {UPDATE_TO} > {UPDATE_FROM} -->
                <span>{UPDATE_FROM} &mdash; {UPDATE_TO}</span>
                <!-- ENDIF -->
            </div>

            <div id="content">
                <h3>{UPDATE_TITLE}</h3>
                {FILE "{PHP.cotPath.skins}/{PHP.cfg.defaulttheme}/warnings.tpl"}

                <!-- BEGIN: COMPLETED -->
                <p class="complete">
                    <span>{UPDATE_COMPLETED_NOTE}</span>

                    <a href="{PHP.cfg.mainurl}"><strong>{PHP.L.install_view_site}</strong></a>
                </p>
                <!-- END: COMPLETED -->
            </div>
        </div>
    </body>
</html>
<!-- END: MAIN -->
