<?php

/**
* 
*/
class Param
{
	
	function start() {
		global $starttime;
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
		$mtime = $mtime[1] + $mtime[0];
		$starttime = $mtime;
	}

	function stop() {
		global $starttime;
		$mtime = microtime();
		$mtime = explode( ' ', $mtime );
		$mtime = $mtime[1] + $mtime[0];
		$endtime = $mtime;
		$totaltime = round( ($endtime - $starttime), 5 );
		return $totaltime;
	}

	function memory()
	{
		$memory = memory_get_usage();
		if($memory < 1024)
		{
			$memory .= " байт";
			return $memory;
		}
		else
		{
			$memory = $memory/1024;
			if($memory < 1024)
			{
				$memory = round($memory)." кб";
				return $memory;
			}
			else
			{
				$memory = $memory/1024;
				$memory = round($memory)." мб";
				return $memory;
			}
		}
	}
}

?>