<?php
declare(strict_types=1);
/**
 * StdoutDriver - A logger driver for streaming logs to the standard output.
 *
 * @package    Artex\Logger\Drivers
 * @link       https://github.com/artex-agency/artex-logger
 * @link       https://artexsoftware.com
 * @license    Apache License 2.0
 * @copyright  2025 Artex Agency Inc.
 */
namespace Artex\Logger\Drivers;

use Artex\Logger\LoggerInterface;

/**
 * StdoutDriver class
 * Implements LoggerInterface.
 * 
 * @version 1.0.0
 * @author  James Gober <me@jamesgober.com>
 */
class StdoutDriver implements LoggerInterface
{
    /**
     * @var string Output format, either 'json' or 'text'.
     */
    private string $format;

    /**
     * Log level labels for human-readable output.
     */
    private const LOG_LEVELS = [
        100 => 'DEBUG',
        200 => 'INFO',
        250 => 'NOTICE',
        300 => 'WARNING',
        400 => 'ERROR',
        500 => 'CRITICAL',
        550 => 'ALERT',
        600 => 'EMERGENCY',
    ];

    /**
     * Constructor for StdoutDriver.
     *
     * @param string $format Output format, either 'json' (default) or 'text'.
     */
    public function __construct(string $format = 'json')
    {
        $this->format = $format;
    }

    /**
     * Logs a message with the specified severity level and context.
     *
     * @param int $level The log level (e.g., DEBUG, INFO, ERROR).
     * @param string $message The log message.
     * @param array $context Optional context data.
     * 
     * @return void
     */
    public function log(int $level, string $message, array $context = []): void
    {
        $logEntry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'level'     => self::LOG_LEVELS[$level] ?? 'UNKNOWN',
            'message'   => $message,
            'context'   => $this->serializeContext($context),
        ];

        $this->output($logEntry);
    }

    /**
     * Outputs the log entry to the standard output.
     *
     * @param array $logEntry The log entry as an associative array.
     * 
     * @return void
     */
    private function output(array $logEntry): void
    {
        try {
            if ($this->format === 'json') {
                echo json_encode($logEntry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
            } else {
                echo "[{$logEntry['timestamp']}] {$logEntry['level']}: {$logEntry['message']} " .
                    json_encode($logEntry['context'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . PHP_EOL;
            }
        } catch (\Throwable $e) {
            // Fail silently if unable to output
        }
    }

    /**
     * Serializes the context array for output.
     *
     * @param array $context The context data.
     * 
     * @return array|string The serialized context.
     */
    private function serializeContext(array $context): array|string
    {
        return array_map(function ($value) {
            if (is_object($value)) {
                return method_exists($value, '__toString') ? (string) $value : get_class($value);
            }

            return $value;
        }, $context);
    }
}