--TEST--
convert_bytes() - function
--FILE--
<?php
var_dump(convert_bytes(1000000000, MEMORY_UNIT_BYTE));
var_dump(convert_bytes(1000000000, MEMORY_UNIT_KILOBYTE));
var_dump(convert_bytes(1000000000, MEMORY_UNIT_MEGABYTE));
var_dump(convert_bytes(1000000000, MEMORY_UNIT_GIGABYTE));

try {
    convert_bytes(-1, MEMORY_UNIT_GIGABYTE);
} catch(ValueError $exception) {
    echo $exception->getMessage() . PHP_EOL;
}

try {
    convert_bytes(0, 0);
} catch(ValueError $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
?>
--EXPECT--
float(1000000000)
float(1000000)
float(1000)
float(1)
convert_bytes(): Argument #1 ($bytes) must be greater or equal to 0 (zero)
convert_bytes(): Argument #2 ($unit) must be greater or equal to 1
