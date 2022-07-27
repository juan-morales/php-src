--TEST--
convert_bytes() - function
--FILE--
<?php
define("MEMORY_UNIT_BYTE", 1);
define("MEMORY_UNIT_KILOBYTE", 2);
define("MEMORY_UNIT_MEGABYTE", 3);
define("MEMORY_UNIT_GIGABYTE", 4);

var_dump(convert_bytes(1000000000, MEMORY_UNIT_BYTE));
var_dump(convert_bytes(1000000000, MEMORY_UNIT_KILOBYTE));
var_dump(convert_bytes(1000000000, MEMORY_UNIT_MEGABYTE));
var_dump(convert_bytes(1000000000, MEMORY_UNIT_GIGABYTE));
?>
--EXPECT--
float(1000000000)
float(1000000)
float(1000)
float(1)
