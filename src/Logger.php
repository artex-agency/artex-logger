<?php declare(strict_types=1);
# ¸_____¸____¸________¸___¸_¸  ¸__   
# |     |  __ \_¸  ¸_/  __|  \/  /   
# |  |  |     / |  | |  __|}    {    
# |__A__|__\__\ |__| |____|__/\__\
# ARTEX SOFTWARE ⦙⦙⦙⦙⦙⦙ PSR-3 LOGGING
/**
 * Artex Exception Library
 * 
 * @package    Artex\Logger
 * @link       https://github.com/artex-agency/artex-logger
 * @link       https://artexsoftware.com
 * @license    Apache License 2.0
 * @copyright  2025 Artex Agency Inc.
 */
namespace Artex\Logger;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

/**
 * Logger Class
 *
 * A lightweight, PSR-3-compliant logger designed for flexibility and performance.
 * Includes shortcut methods for logging at specific levels.
 * 
 * @version  1.0.0
 * @author   James Gober <me@jamesgober.com>
 */
class Logger extends AbstractLogger
{
    /**
     * @var int The minimum log level threshold.
     */
    private int $threshold;

    /**
     * Constructs a new Logger instance with the specified log level threshold.
     *
     * @param int $threshold The minimum log level to record (default: 0 - log everything).
     */
    public function __construct(int $threshold = 0)
    {
        $this->threshold = $threshold;
    }

    /**
     * Logs a message with the specified severity level and optional context data.
     *
     * @param mixed  $level   The log level (e.g., DEBUG, INFO, ERROR).
     * @param string $message The log message.
     * @param array  $context Additional context data to include (default: empty array).
     *
     * @return void
     */
    public function log($level, string $message, array $context = []): void
    {
        $numericLevel = $this->convertLogLevel($level);

        if ($numericLevel < $this->threshold) {
            return;
        }

        $logEntry = [
            'code'      => $numericLevel,
            'level'     => $this->getLogLabel($numericLevel),
            'timestamp' => date('Y-m-d H:i:s'),
            'message'   => $this->interpolateMessage($message, $context),
            'context'   => $context,
        ];

        // Call storage logic here (e.g., write to a file or send to an external service)
        $this->writeLog($logEntry);
    }

    /**
     * Shortcut method for logging an EMERGENCY-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function emergency(string $message, array $context = []): void
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Shortcut method for logging an ALERT-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function alert(string $message, array $context = []): void
    {
        $this->log('alert', $message, $context);
    }

    /**
     * Shortcut method for logging a CRITICAL-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function critical(string $message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    /**
     * Shortcut method for logging an ERROR-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function error(string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    /**
     * Shortcut method for logging a WARNING-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    /**
     * Shortcut method for logging a NOTICE-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function notice(string $message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    /**
     * Shortcut method for logging an INFO-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function info(string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    /**
     * Shortcut method for logging a DEBUG-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log('debug', $message, $context);
    }


    /**
     * Retrieves the stored log entries.
     * Useful for debugging or in-memory logging.
     *
     * @return array The array of log entries.
     */
    public function getLogs(): array
    {
        return $this->logs;
    }

    /**
     * Converts a log level (either string or int) into its numeric representation.
     *
     * @param mixed $level The log level.
     *
     * @return int The numeric log level.
     */
    private function convertLogLevel($level): int
    {
        $logLevels = [
            'emergency' => 600,
            'alert'     => 550,
            'critical'  => 500,
            'error'     => 400,
            'warning'   => 300,
            'notice'    => 250,
            'info'      => 200,
            'debug'     => 100,
        ];

        if (is_int($level)) {
            return min(max($level, 100), 600); // Ensure level is within bounds
        }

        return $logLevels[strtolower($level)] ?? 0;
    }

    /**
     * Retrieves the string label for a given numeric log level.
     *
     * @param int $level The numeric log level.
     *
     * @return string The log level label.
     */
    private function getLogLabel(int $level): string
    {
        return match ($level) {
            600 => 'EMERGENCY',
            550 => 'ALERT',
            500 => 'CRITICAL',
            400 => 'ERROR',
            300 => 'WARNING',
            250 => 'NOTICE',
            200 => 'INFO',
            100 => 'DEBUG',
            default => 'UNKNOWN',
        };
    }

    /**
     * Interpolates context values into the log message placeholders.
     *
     * @param string $message The log message with placeholders.
     * @param array  $context The context data to replace placeholders.
     *
     * @return string The interpolated log message.
     */
    private function interpolateMessage(string $message, array $context): string
    {
        $replace = [];
        foreach ($context as $key => $value) {
            $replace['{' . $key . '}'] = $value;
        }

        return strtr($message, $replace);
    }

    /**
     * Writes the log entry to a storage medium.
     *
     * @param array $logEntry The log entry data.
     *
     * @return void
     */
    private function writeLog(array $logEntry): void
    {
        // Placeholder: Extend this for file storage, database, etc.
        // Example:
        // file_put_contents('/path/to/logfile.log', json_encode($logEntry) . PHP_EOL, FILE_APPEND);
    }
}