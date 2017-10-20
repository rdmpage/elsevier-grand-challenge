<?php

// encode decimal number into base62 (as in tinyurl.com)

// http://www.phpfreaks.com/forums/index.php/topic,218893.msg1003039.html#msg1003039

function newBase( $i ) {
	static $chars = array(
		'0','1','2','3','4','5','6','7','8','9',
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
		'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'
	);
	$base = count( $chars );
	
	$num = array();
	while( $i > 0 ) {
		$num[] = $chars[ $i % $base ];
		$i = floor( $i / $base );
	}
	
	return implode( '', array_reverse($num) );
}

/*$nums = array();
for( $i=0; $i<1000; $i++ )
	$nums[] = newBase( $i );

print_r( $nums );*/

echo newBase(123456789) . "\n";

?>