#!/usr/bin/env php
<?php

$infile = __DIR__ . '/../../Zend/zend_language_parser.y';
$outfile_stub = __DIR__ . '/tokenizer_data.stub.php';
$outfile_c = __DIR__ . '/tokenizer_data.c';

if (!file_exists($infile)) {
    fwrite(STDERR, <<<ERROR
$infile is missing.

Please, generate the PHP parser files by scripts/dev/genfiles
or by running the ./configure build step.
ERROR
    );
    exit(1);
}

$result = "<?php\n\n/** @generate-class-entries */\n\n";

$incontent = file_get_contents($infile);
preg_match_all('(^%token.*\b(?<token_name>T_.*?)\b)m', $incontent, $matches);

foreach ($matches['token_name'] as $tokenName) {
    if ($tokenName === 'T_NOELSE' || $tokenName === 'T_ERROR') {
        continue;
    }
    $result .= "/**\n * @var int\n * @cvalue $tokenName\n */\n";
    $result .= "const $tokenName = UNKNOWN;\n";
}

$result .= "/**\n * @var int\n * @cvalue T_PAAMAYIM_NEKUDOTAYIM\n */\n";
$result .= "const T_DOUBLE_COLON = UNKNOWN;\n";

file_put_contents($outfile_stub, $result);

echo "Wrote $outfile_stub\n";

$result = <<<CODE
/*
   +----------------------------------------------------------------------+
   | Copyright (c) The PHP Group                                          |
   +----------------------------------------------------------------------+
   | This source file is subject to version 3.01 of the PHP license,      |
   | that is bundled with this package in the file LICENSE, and is        |
   | available through the world-wide-web at the following url:           |
   | https://www.php.net/license/3_01.txt                                 |
   | If you did not receive a copy of the PHP license and are unable to   |
   | obtain it through the world-wide-web, please send a note to          |
   | license@php.net so we can mail you a copy immediately.               |
   +----------------------------------------------------------------------+
   | Author: Johannes Schlueter <johannes@php.net>                        |
   +----------------------------------------------------------------------+
*/

/*
   DO NOT EDIT THIS FILE!
   This file is generated using tokenizer_data_gen.php
*/

#include <zend_language_parser.h>

char *get_token_type_name(int token_type)
{
\tswitch (token_type) {


CODE;

foreach ($matches['token_name'] as $tokenName) {
    if ($tokenName === 'T_NOELSE' || $tokenName === 'T_ERROR') {
        continue;
    }
    if ($tokenName === 'T_PAAMAYIM_NEKUDOTAYIM') {
        $result .= "\t\tcase T_PAAMAYIM_NEKUDOTAYIM: return \"T_DOUBLE_COLON\";\n";
    } else {
        $result .= "\t\tcase $tokenName: return \"$tokenName\";\n";
    }
}

$result .= <<<CODE

\t}
\treturn NULL;
}


CODE;

file_put_contents($outfile_c, $result);

echo "Wrote $outfile_c\n";
