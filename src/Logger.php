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
use Stringable;

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
     * @var int Minimum log level threshold.
     */
    private int $threshold;

    /**
     * @var string File path for storing log entries.
     */
    private string $logFilePath;

    /**
     * @var int|null Maximum file size for log rotation (bytes).
     */
    private int $maxFileSize;

    /**
     * @var bool Asynchronous logging flag.
     */
    private bool $async;

    /**
     * Constructor.
     *
     * @param int    $threshold   Minimum log level to record.
     * @param string $logFilePath Path to the log file.
     * @param int    $maxFileSize Max file size in bytes before rotation.
     * @param bool   $async       Whether to enable asynchronous logging.
     */
    public function __construct(int $threshold = 0, string $logFilePath = '/tmp/app.log', int $maxFileSize = 10485760, bool $async = false)
    {
        $this->threshold = $threshold;
        $this->logFilePath = $logFilePath;
        $this->maxFileSize = $maxFileSize;
        $this->async = $async;
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
    public function log($level, Stringable|string $message, array $context = []): void
    {
        $numericLevel = $this->convertLogLevel($level);

        if ($numericLevel < $this->threshold) {
            return;
        }

        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level'     => $this->getLogLabel($numericLevel),
            'message'   => $this->interpolateMessage($message, $context),
            'context'   => $context,
        ];

        $this->writeLog($logEntry);
    }

    /**
     * Shortcut method for logging an EMERGENCY-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Shortcut method for logging an ALERT-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->log('alert', $message, $context);
    }

    /**
     * Shortcut method for logging a CRITICAL-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    /**
     * Shortcut method for logging an ERROR-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function error(Stringable|string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    /**
     * Shortcut method for logging a WARNING-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    /**
     * Shortcut method for logging a NOTICE-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    /**
     * Shortcut method for logging an INFO-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function info(Stringable|string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }
    

    /**
     * Shortcut method for logging a DEBUG-level message.
     *
     * @param string $message
     * @param array  $context
     */
    public function debug(Stringable|string $message, array $context = []): void
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
     * Converts a log level (string or int) to its numeric representation.
     *
     * @param mixed $level The log level.
     *
     * @return int Numeric log level.
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
            return min(max($level, 100), 600);
        }

        return $logLevels[strtolower((string) $level)] ?? 0;
    }

    /**
     * Gets the label for a numeric log level.
     *
     * @param int $level Numeric log level.
     *
     * @return string Log level label.
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
     * @return string Interpolated log message.
     */
    private function interpolateMessage(Stringable|string $message, array $context): string
    {
        $replace = [];
        foreach ($context as $key => $value) {
            $replace['{' . $key . '}'] = is_scalar($value) ? $value : json_encode($value);
        }

        return strtr((string)$message, $replace);
    }

    /**
     * Writes the log entry to a storage medium with a customizable format.
     *
     * @param array $logEntry The log entry data.
     *
     * @return void
     */
    private function writeLog(array $logEntry): void
    {
        $formattedLog = json_encode($logEntry) . PHP_EOL;
    
        // Rotate the log file if necessary
        $this->rotateLogFile();
    
        if ($this->async) {
            $this->writeAsync($formattedLog);
        } else {
            file_put_contents($this->logFilePath, $formattedLog, FILE_APPEND | LOCK_EX);
        }
    }
    

    /**
     * Formats the log entry based on the given pattern.
     *
     * @param array  $logEntry The log entry data.
     * @param string $pattern  The log pattern (e.g., "[{timestamp}] {level}: {message}").
     *
     * @return string The formatted log entry.
     */
    private function formatLog(array $logEntry, string $pattern): string
    {
        $placeholders = [
            '{timestamp}' => $logEntry['timestamp'] ?? '',
            '{level}'     => $logEntry['level'] ?? 'UNKNOWN',
            '{message}'   => $logEntry['message'] ?? '',
            '{context}'   => empty($logEntry['context']) ? '{}' : json_encode($logEntry['context']),
        ];
    
        return strtr($pattern, $placeholders);
    }

    /**
     * Rotates the log file if it exceeds the maximum size.
     *
     * @return void
     */
    private function rotateLogFile(): void
    {
        if (file_exists($this->logFilePath) && filesize($this->logFilePath) >= $this->maxFileSize) {
            $backupPath = $this->logFilePath . '.' . time();
            rename($this->logFilePath, $backupPath);
        }
    }

    /**
     * Writes log asynchronously.
     *
     * @param string $logLine The log line to write.
     *
     * @return void
     */
    private function writeAsync(string $logLine): void
    {
        $process = proc_open(
            'php',
            [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']],
            $pipes
        );

        if (is_resource($process)) {
            fwrite($pipes[0], '<?php file_put_contents("' . addslashes($this->logFilePath) . '", ' . var_export($logLine, true) . ', FILE_APPEND);');
            fclose($pipes[0]);
            proc_close($process);
        }
    }
}