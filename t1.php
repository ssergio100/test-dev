<?php
$numbers = [1,2,3,4];

$squares = array_map(

		function($number) {
			return $number * $number;
		}, $numbers

	);
  print_r($squares);



$a = array(1, 2, 3, 4, 5);

$b = array_map(function($n) {

    return $n.'-'.($n * $n * $n);

}, $a);

print_r($b);