<?php
include 'vendor/autoload.php';

$logger = ArashDalir\UdpSysLog\Handler\UdpSysLog::test();

print_r($logger);