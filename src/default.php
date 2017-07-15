<?php
/**
 * @file default.php
 * It is one laucher script of zphar tool.
 * The tool to package the php scripts as phar format
 * @author Peter (peter.ziv@hotmail.com)
 * @copyright (c) 2016, Peter
 * @date Oct 12, 2016
 *
 */
date_default_timezone_set('PRC');
require_once __DIR__ . '/PharPackage.php';

$a = new \ZKit\console\zphar\PharPackage();
$a->run( $argv );
