<?
function site_menu()
{
	if(!Registry::getInstance()->Template->station_menu = Registry::getInstance()->Cache->Get('station_menu', 259200)) {
		$result_index = Registry::getInstance()->DataBase->Query("SELECT * FROM menu ORDER BY position");
		$myrow_index = Registry::getInstance()->DataBase->GetArray($result_index);

		Registry::getInstance()->Template->station_menu = '';

		if($myrow_index != "")
		{
			$sm_read = Registry::getInstance()->Template->Fetch('station_menu');
			preg_match("/\[_divmenu\](.*?)\[_divmenu\]/s",$sm_read,$div_menu);
			do
			{
				$edd_tamp = $div_menu[1];
				$edd_tamp = str_replace("[_href]",$myrow_index['href'],$edd_tamp);//Ссылка
				$edd_tamp = str_replace("[_link]",$myrow_index['name'],$edd_tamp);//Текст ссылки
				Registry::getInstance()->Template->station_menu .= $edd_tamp;
			}
			while($myrow_index = Registry::getInstance()->DataBase->GetArray($result_index));
				Registry::getInstance()->Template->station_menu = preg_replace("/\[_divmenu\].*?\[_divmenu\]/s",Registry::getInstance()->Template->station_menu,$sm_read);
		}

		Registry::getInstance()->Cache->Set("station_menu", Registry::getInstance()->Template->station_menu);
	}

return Registry::getInstance()->Template->station_menu;
}

?>