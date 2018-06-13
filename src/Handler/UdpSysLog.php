<?php
/**
 * Created by PhpStorm.
 * User: ada
 * Date: 11-Jun-18
 * Time: 17:03
 */

namespace ArashDalir\UdpSysLog\Handler;

use Analog\Analog;
use ArashDalir\Handler\SysLog\SysLog;
use ArashDalir\Handler\SysLog\SysLogMessage;
use Psr\Log\LogLevel;

/**
 * Send the log message to the syslog service. This was borrowed largely
 * from the Monolog syslog handler.
 *
 * Usage:
 *
 *     Analog::handler (ArashDalir\UdpSysLog\Handler\UdpSyslog::init ('ip-address', 'port', 'facility', 'syslog-version', 'host-name', 'app-name', 'process-id', 'message-id', 'auto-message-id'));
 */
class UdpSysLog{
	static function init($address, $port = 514, $facility = LOG_USER, $version = SysLogMessage::VERSION_1, $host_name = null, $app_name = null, $process_id = "auto", $message_id = null, $auto_message_id = null){
		static $logger;
		if (!$logger)
		{
			$logger = new SysLog($address, $port);
		}

		if ($process_id == "auto")
		{
			$process_id = getmypid();
		}

		$logger->getLogMessage()
			->setVersion($version)
			->setFacility($facility, false)
			->setHostName($host_name)
			->setAppName($app_name)
			->setMessageId($message_id)
			->setAutoMessageId($auto_message_id)
			->setProcessId($process_id);

		return function($info) use ($logger)
		{
			if (!$logger->getLogMessage()->getHostName())
			{
				$logger->getLogMessage()->setHostName($info["machine"]);
			}

			$levels = array(
				Analog::URGENT => LogLevel::EMERGENCY,
				Analog::ALERT => LogLevel::ALERT,
				Analog::CRITICAL => LogLevel::CRITICAL,
				Analog::ERROR => LogLevel::ERROR,
				Analog::WARNING => LogLevel::WARNING,
				Analog::NOTICE => LogLevel::NOTICE,
				Analog::INFO => LogLevel::INFO,
				Analog::DEBUG => LogLevel::DEBUG,
			);

			if (!isset($levels[$info["level"]]))
			{
				$level = LogLevel::EMERGENCY;
			}
			else
			{
				$level = $levels[$info["level"]];
			}
			return $logger->log($level, $info["message"], array(), strtotime($info["date"]));

		};
	}
}