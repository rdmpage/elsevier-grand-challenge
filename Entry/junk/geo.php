<?php

// develop regular expression, using a testing framework

$locs = array();
$failed = array();

array_push($locs, 'N10° 54.448\'');
array_push($locs, 'W85° 02.494\'');
array_push($locs, '114.1E\40.1N');
$ok = 0;
foreach ($locs as $str)
{
	$success = false;
	
	if (preg_match('/(?<hemisphere>[N|W])(?<degrees>[0-9]{1,2})°\s*(?<minutes>[0-9]{1,2}(.[0-9]+)?)\'/', $str, $matches))
	{
		print_r($matches);	
		$success = true;
	}
	if (preg_match('/(?<longdegrees>[0-9]{1,3})(?<longminutes>[0-9]{1,2}(.[0-9]+)?)(?<longhemisphere>[W|E])\\\(?<latdegrees>[0-9]{1,3})(?<latminutes>[0-9]{1,2}(.[0-9]+)?)(?<lathemisphere>[N|S])/', $str, $matches))
	{
		print_r($matches);	
		$success = true;
	}
	
	
	
	if ($success)
	{
		$ok++;
	}
	else
	{
		array_push($failed, $str);
	}
}

// report

echo "--------------------------\n";
echo count($locs) . ' localities, ' . (count($locs) - $ok) . ' failed' . "\n";
print_r($failed);

?>


			
