<?
function site_menu()
{
	if(!Niun::getInstance()->Get('Template')->station_menu = Niun::getInstance()->Get('Cache')->Get('station_menu', 259200)) {
		$result_index = Niun::getInstance()->Get('DataBase')->Query("SELECT * FROM menu ORDER BY position");
		$myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index);

		Niun::getInstance()->Get('Template')->station_menu = '';

		if($myrow_index != "")
		{
			$sm_read = Niun::getInstance()->Get('Template')->Fetch('station_menu');
			preg_match("/\[_divmenu\](.*?)\[_divmenu\]/s",$sm_read,$div_menu);
			do
			{
				$edd_tamp = $div_menu[1];
				$edd_tamp = str_replace("[_href]",$myrow_index['href'],$edd_tamp);//Ссылка
				$edd_tamp = str_replace("[_link]",$myrow_index['name'],$edd_tamp);//Текст ссылки
				Niun::getInstance()->Get('Template')->station_menu .= $edd_tamp;
			}
			while($myrow_index = Niun::getInstance()->Get('DataBase')->GetArray($result_index));
				Niun::getInstance()->Get('Template')->station_menu = preg_replace("/\[_divmenu\].*?\[_divmenu\]/s",Niun::getInstance()->Get('Template')->station_menu,$sm_read);
		}

		Niun::getInstance()->Get('Cache')->Set("station_menu", Niun::getInstance()->Get('Template')->station_menu);
	}

return Niun::getInstance()->Get('Template')->station_menu;
}

?>