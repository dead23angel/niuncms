<?php

function stats()
{
	if(!Niun::getInstance()->Get('Template')->stats = Niun::getInstance()->Get('Cache')->Get('stats', 86400))
	{
		$template = Niun::getInstance()->Get('Template')->Fetch('stats');

		$row      = Niun::getInstance()->Get('DataBase')->GetArray(Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) as count FROM blog"));
		$allnews  = $row['count'];

		$row      = Niun::getInstance()->Get('DataBase')->GetArray(Niun::getInstance()->Get('DataBase')->Query("SELECT COUNT(*) as count FROM user"));
		$allusers = $row['count'];

		$template = str_replace('{allnews}', $allnews, $template);
		$template = str_replace('{allusers}', $allusers, $template);

		Niun::getInstance()->Get('Template')->stats = $template;

		Niun::getInstance()->Get('Cache')->Set('stats', Niun::getInstance()->Get('Template')->stats);
	}

	return Niun::getInstance()->Get('Template')->stats;
}

?>