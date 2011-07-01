<?php
function convert_to_seconds($timestamp)
{
	$year = substr($timestamp,0,4) + 0;
	$month = substr($timestamp,5,2)+ 0;
	$day = substr($timestamp,8,2)+ 0;
	$hour = substr($timestamp,11,2)+ 0;
	$min = substr($timestamp,14,2)+ 0;
	$seconds = substr($timestamp,17,2)+ 0;
	return mktime($hour,$min,$seconds,$month,$day,$year,0);
}

function time_between($start,$end,$after =' ago',$posted = ' posted ',$color=1){
	//both times must be in seconds
	$time = $end - $start;
	if($time <= 60){
		if($color==1){
			return '<span style="color:#0404B4;">Recently</span>';
		}else{
			return 'Recently';
		}
	}
	if(60 < $time && $time <= 3600){
		return $posted .round($time/60,0).' minute(s)'.$after;
	}
	if(3600 < $time && $time <= 86400){
		return $posted .round($time/3600,0).' hour(s)'.$after;
	}
	if(86400 < $time && $time <= 604800){
		return $posted .round($time/86400,0).' day(s)'.$after;
	}
	if(604800 < $time && $time <= 2592000){
		return $posted .round($time/604800,0).' week(s)'.$after;
	}
	if(2592000 < $time && $time <= 29030400){
		return $posted .round($time/2592000,0).' month(s)'.$after;
	}
	if($time > 29030400){
		return $posted .'More than a year'.$after;
	}
}
?>