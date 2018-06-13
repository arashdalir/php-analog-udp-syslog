<?php
include 'vendor/autoload.php';
use ArashDalir\UdpSysLog\Handler\UdpSyslog;

$logger = new Analog\Logger();
Analog::$timezone = "Europe/Vienna";
$logger->handler(UdpSysLog::init('127.0.0.1', 514, LOG_USER, \ArashDalir\Handler\SysLog\SysLogMessage::VERSION_1, "ada.gemik", "AnalogSysLog", "auto", null, 0));

$logger->alert("testing alert-level udp-syslog for analog");
$logger->alert("testing alert-level udp-syslog for analog");
$logger->alert("testing alert-level udp-syslog for analog");
$logger->info("testing info-level udp-syslog for analog");