<?php

/*
************************************************************
Litotex BrowsergameEngine
http://www.Litotex.de
http://www.freebg.de

Copyright (c) 2008 FreeBG Team
************************************************************
Hinweis:
Diese Software ist urheberechtlich geschützt.

Für jegliche Fehler oder Schäden, die durch diese Software
auftreten könnten, übernimmt der Autor keine Haftung.

Alle Copyright - Hinweise Innerhalb dieser Datei
dürfen NICHT entfernt und NICHT verändert werden.
************************************************************
Released under the GNU General Public License
************************************************************
*/

if (!isset($_SESSION['userid'])) die('Schwerer Fehler, bitte loggen sie sich erneut ein! <a href="' . $_SESSION['litotex_start_acp'] .
        'acp">Admin-Login</a>');
//Überprüfen ob die Seite betrachtet werden darf...
$user = $db->select("SELECT `userid`, `group`, `serveradmin` FROM `cc" . $n . "_users` WHERE `userid` = '" . $_SESSION['userid'] .
    "'");
if (!isset($modul_name))
{
    error_msg('Schwerer Fehler! Es wurde kein Modulname gefunden!');
    exit;
}
if (!$user['serveradmin'])
{
    $grp = $db->select("SELECT `perm_lvl`, `id` FROM `cc" . $n . "_user_groups` WHERE `id` = '" . $user['group'] . "'");
    if (!$grp)
    {
        error_msg('Schwerer Fehler! Die Usergruppe konnte nicht gefunden werden!');
        exit;
    }
    $mod = $db->select("SELECT `perm_lvl` FROM `cc" . $n . "_modul_admin` WHERE `modul_name` = '" . $db->escape_string($modul_name) .
        "'");
    if (!$mod)
    {
        error_msg('Schwerer Fehler! Das Modul konnte nicht gefunden werden!');
        exit;
    }
    if ($mod['perm_lvl'] > $grp['perm_lvl'])
    {
        error_msg('Schwerer Fehler! Sie haben nicht genügend Berechtigungen!');
        exit;
    }
}