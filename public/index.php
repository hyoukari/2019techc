<?php
	if (isset($_COOKIE["counter"]))
	{
		$count = $_COOKIE["counter"] + 1;
	}
	else
	{
		$count = 1;
	}
	setcookie("counter", $count);

	echo("<h1>アクセスカウンター</h1>");
	echo("アクセス回数：{$count}");

