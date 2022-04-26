<?php
namespace App\Utilities;

class TimeUtil
{
    function jalaliDate($sqlTimestamp)
	{
		$unixTimestamp=strtotime($sqlTimestamp);
		return jdate("j F Y",$unixTimestamp);
	}
}
?>