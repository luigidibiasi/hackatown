<?php

	function parseDate($txt)
	{
		return substr($txt,6,2)."/".substr($txt,4,2)."/".substr($txt,0,4);
	}
	function parseTime($txt)
	{
		return substr($txt,0,2).":".substr($txt,3,2);	}


	function sql_query($string)
	{
		$server = "localhost";
		$user = "root";
		$pass = "password";
		$dbname = "posts";

		$conn = mysql_connect($server,$user,$pass) or die("Connect error");
		$sel = mysql_select_db($dbname,$conn);
		$toret = mysql_query($string);
		return $toret;

	}
?>
