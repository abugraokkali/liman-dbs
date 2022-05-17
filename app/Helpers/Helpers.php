<?php

if (!function_exists('getVersion')) {
	function getVersion()
	{
		$json = json_decode(file_get_contents(getPath("db.json")), true);
		return $json["version"];
	}
}
