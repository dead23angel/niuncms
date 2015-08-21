<?php
### NiunCMS - Community Management System    ###
### Powered by CWTeam                        ###
### Лицензия: GNU/GPL v3                     ###
### Официальный сайт NiunCMS: www.niuncms.ru ###

if(!$q = Registry::getInstance()->Cache->Get('pollid', 604800))
{
	$result_poll = Registry::getInstance()->DataBase->Query("SELECT `id` FROM poll WHERE activ = '1'");
	$myrow_poll = Registry::getInstance()->DataBase->GetArray($result_poll);

	$q = "quest_".$myrow_poll['id'];
	
	Registry::getInstance()->Cache->Set("pollid",$q);
}

if (isset($_POST['quePOLL'])){$quePOLL = $_POST['quePOLL'];}
if(isset($quePOLL))
{
	if(preg_match("/^[0-9]+$/",$quePOLL))
	{
		$result_pollup = Registry::getInstance()->DataBase->Query("SELECT `otvet` FROM poll WHERE activ = '1'");
		$myrow_pollup = Registry::getInstance()->DataBase->GetArray($result_pollup);

		$otvet = explode("|",$myrow_pollup['otvet']);
		$otvet[$quePOLL]++;
		$otvet = implode("|",$otvet);
		$result_up_q = Registry::getInstance()->DataBase->Query ("UPDATE poll SET otvet='$otvet' WHERE activ='1'");
	
		preg_match("/http:\/\/(.*?)\//s",$server_root,$cookieSITE);
		$cookieSITE = str_replace("www.","",$cookieSITE[1]);
	
		setcookie($q,"YES",time()+31536000,"/",".".$cookieSITE);
	
		Registry::getInstance()->Cache->Clean("poll");
		Registry::getInstance()->Cache->Clean("pollform");
	}	
	header("location: ".getenv('HTTP_REFERER'));
	exit;	
}

function poll($step)
{
$result_index = Registry::getInstance()->DataBase->Query("SELECT * FROM poll WHERE activ = '1'");
$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);

if($myrow_index != "")
{
$val = explode("|",$myrow_index['value']);
$kol = explode("|",$myrow_index['otvet']);

if($step == 0)
{
	$result = "<div id=\"queFORM\" style=\"display:block;\">".opros($val,$myrow_index['que'])."</div>";
	$result .= "<div id=\"queRESULT\" style=\"display:none;\">".resultQUE($val,$kol,$myrow_index['que'],0)."</div>";
}
else $result = resultQUE($val,$kol,$myrow_index['que'],1);
}
return $result;
}

function opros($val,$que)
{
$sm_read = Registry::getInstance()->Template->Fetch('pollFORM');

$sm_read = str_replace("[_qu]",$que,$sm_read);
preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$a);

for($i=0;isset($val[$i]);$i++)
{
$edd_tamp = $a[1];

$poll = (!isset($poll)) ? '' : $poll;

if($i == 0)$edd_tamp = str_replace("[_checked]"," checked",$edd_tamp);
else $edd_tamp = str_replace("[_checked]","",$edd_tamp);
$edd_tamp = str_replace("[_sub]",$i,$edd_tamp);
$edd_tamp = str_replace("[_val]",$val[$i],$edd_tamp);
$poll .= $edd_tamp;
}
$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$poll,$sm_read);

return $sm_read;
}

function resultQUE($val,$kol,$que,$step)
{
$sm_read = Registry::getInstance()->Template->Fetch('poll');

$sm_read = str_replace("[_qu]",$que,$sm_read);
preg_match("/\[_while\](.*?)\[_while\]/s",$sm_read,$a);

$all = 0;
for($i=0;isset($val[$i]);$i++)
{

$poll = (!isset($poll)) ? '' : $poll;

$edd_tamp = $a[1];

$edd_tamp = str_replace("[_kol]",$kol[$i],$edd_tamp);
$edd_tamp = str_replace("[_val]",$val[$i],$edd_tamp);
$edd_tamp = str_replace("[_pn]", $i, $edd_tamp);

$all = $all + $kol[$i];

$poll .= $edd_tamp;
}

$sm_read = str_replace("[_all]",$all,$sm_read);
if($step == 0)$sm_read = str_replace("[_bottom]","",$sm_read);
else $sm_read = preg_replace("/\[_bottom\].*?\[_bottom\]/s","",$sm_read);
$sm_read = preg_replace("/\[_while\].*?\[_while\]/s",$poll,$sm_read);

return $sm_read;
}
?>