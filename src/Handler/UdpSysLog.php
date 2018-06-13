<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 17:03
 */

namespace ArashDalir\UdpSysLog\Handler;

use ArashDalir\Handler\SysLog\SysLog;
use ArashDalir\Handler\SysLog\SysLogMessage;

/**
 * Send the log message to the syslog service. This was borrowed largely
 * from the Monolog syslog handler.
 *
 * Usage:
 *
 *     Analog::handler (ArashDalir\UdpSysLog\Handler\UdpSyslog::init ('ip-address', 'port', 'facility', 'syslog-version'));
 */
class UdpSysLog{
	static function init($address, $port = 514, $facility = LOG_USER, $version = SysLogMessage::VERSION_1){
		$logger = new SysLog($address, $port);
		$logger->getLogMessage()
			->setVersion($version)
			->setFacility($facility, false);

		return function($info) use ($logger)
		{
			$logger->getLogMessage()->setHostName($info["machine"]);

			$logger->log($info["level"], $info["message"], array(), $info["timestamp"]);
		};
	}
}