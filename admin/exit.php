<?php
### NiunCMS - Community Management System ###
### Powered by SibWeb Media Group         ###
### Лицензия: GNU/GPL v3                  ###
### Официальный сайт NiunCMS: www.niun.ru ###

define('ADMINPART',true);

include("../source/admincp/module/authoriz.php");
checketHESH();

if(isset($_GET['page']))$page = $_GET['page'];
?>
<?
if($page == 'logSESS')
{
?>
<style>
.input {
  border: 1px solid #c1c1c1;
  width:100%;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  box-shadow: 0px 1px 0px white;
  -webkit-box-shadow: 0px 1px 0px white;
  -moz-box-shadow: 0px 1px 0px white;
  -webkit-text-shadow: 0px 1px 0px white;
  -moz-text-shadow: 0px 1px 0px white;
  -o-text-shadow: 0px 1px 0px white;
  text-shadow: 0px 1px 0px white;
  font-family: inherit;
  line-height: 27px;
  font-size: 11px;
  color: #555555 !important;
  height: 28px;
  padding: 0px 10px;
  background-color: white;
  background-image: -webkit-gradient(linear, left top, left bottom, from(white), to(#f2f2f2));
  background-image: -webkit-linear-gradient(top, white, #f2f2f2);
  background-image: -moz-linear-gradient(top, white, #f2f2f2);
  background-image: -o-linear-gradient(top, white, #f2f2f2);
  background-image: -ms-linear-gradient(top, white, #f2f2f2);
  background-image: linear-gradient(top, white, #f2f2f2);
  filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#ffffff', EndColorStr='#f2f2f2');
  cursor: pointer;
  display: inline-block;
  outline: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
}
.input.small {
  padding: 0px 6px;
  height: 25px;
  line-height: 25px;
}
.input:hover, .input:active, .input:focus {
  background-color: #f5f5f5;
  background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#e9e9e9));
  background-image: -webkit-linear-gradient(top, #f5f5f5, #e9e9e9);
  background-image: -moz-linear-gradient(top, #f5f5f5, #e9e9e9);
  background-image: -o-linear-gradient(top, #f5f5f5, #e9e9e9);
  background-image: -ms-linear-gradient(top, #f5f5f5, #e9e9e9);
  background-image: linear-gradient(top, #f5f5f5, #e9e9e9);
  filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0,StartColorStr='#f5f5f5', EndColorStr='#e9e9e9');
}
</style>
<title>Выход из AdminCP</title>
<center>Вы действительно собираетесь покинуть AdminCP?</center>
<br />
<table align = "center">
<td>
<input onclick="javascript:location.href='?page=yes'" class="input" type="button" value="Покинуть AdminCP">
</td>
<td>
<input onclick="javascript:location.href='?page=no'" class="input" type="button" value="Вернуться">
</td>
</table>
<?
$trueSUPPORT = 1;
}
if($page == 'yes')
{
?>
<?
session_start();//стартуем сессию
unset ($_SESSION['logSESS']);//удаляем зарегестрированную глобальную переменную
session_destroy();//уничтожаем сессию
header("location: ../");//перебрасываем на главную страницу пользовательской части блога
exit;
?>
<?
$trueSUPPORT = 1;
}
if($page == 'no')
{
?>
<?
header("location: ../admincp/index.php");//перебрасываем на главную страницу пользовательской части блога
exit;
?>
<?
$trueSUPPORT = 1;
}
?>
