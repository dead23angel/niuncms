<?php
### NiunCMS - Community Management System ###
### Powered by SibWeb Media Group         ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

if(!defined('ADMINPART')) die();

include("../source/developers/modules/blocki/admincp/function/control.php");
if (!isset($_GET['addrsv']))$txt = allrsv();
if (isset($_GET['addrsv'])) $txt = addrsv();
if (isset($edd_rsv)) $txt = edd_rsv($edd_rsv);

?>