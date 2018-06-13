# UdpSysLog

`ArashDalir/UdpSysLog` works as a bridge between [analog/analog](https://github.com/jbroadway/analog) and [arashdalir/psr3-log/handler/syslog](https://github.com/arashdalir/php-psr3log) which allows sending syslog events over UDP to a syslog server. It also can write syslog events into a local syslog.

## Install

Use following command to add the repository to your project:

	composer require arashdalir/php-analog-udp-syslog


Or add following line to your composer.json:

```json
{
  "require": {
     "arashdalir/php-analog-udp-syslog": "dev-master"
  }
}
```

## Usage

```php
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
```
