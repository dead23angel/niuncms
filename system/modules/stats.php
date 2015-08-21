<?php

function stats()
{
	if(!Registry::getInstance()->Template->stats = Registry::getInstance()->Cache->Get('stats', 86400))
	{
		$template = Registry::getInstance()->Template->Fetch('stats');

		$row      = Registry::getInstance()->DataBase->GetArray(Registry::getInstance()->DataBase->Query("SELECT COUNT(*) as count FROM blog"));
		$allnews  = $row['count'];

		$row      = Registry::getInstance()->DataBase->GetArray(Registry::getInstance()->DataBase->Query("SELECT COUNT(*) as count FROM user"));
		$allusers = $row['count'];

		$template = str_replace('{allnews}', $allnews, $template);
		$template = str_replace('{allusers}', $allusers, $template);

		Registry::getInstance()->Template->stats = $template;

		Registry::getInstance()->Cache->Set('stats', Registry::getInstance()->Template->stats);
	}

	return Registry::getInstance()->Template->stats;
}

?>