<?php declare(strict_types=1);
/**
 * Artex Logger - NullLog
 * 
 * @package    Artex\Logger
 * @link       https://artexsoftware.com
 * @link       https://github.com/artex-agency/artex-logger
 * @license    Apache License 2.0
 * @copyright  2025 Artex Agency Inc.
 */
namespace Artex\Logger\Drivers;

use Psr\Log\LoggerInterface;

/**
 * NullLog Class
 *
 * A no-op logger implementation that silently ignores all log calls.
 * Useful for scenarios where logging is disabled but the logging interface
 * must still be honored.
 * 
 * @package Artex\Logger
 */
class NullLog implements LoggerInterface
{
    /**
     * Logs a message with the specified level and optional context data.
     * This method discards all log messages without taking any action.
     *
     * @param mixed  $level   The log level (e.g., DEBUG, INFO, ERROR).
     * @param string $message The message to log.
     * @param array  $context Additional context data to include (optional).
     * 
     * @return void
     */
    public function log($level, string $message, array $context = []): void
    {
        // Do nothing
    }

    // Add optional PSR-3 convenience methods like debug(), error(), etc., if needed
    public function emergency(string $message, array $context = []): void {}
    public function alert(string $message, array $context = []): void {}
    public function critical(string $message, array $context = []): void {}
    public function error(string $message, array $context = []): void {}
    public function warning(string $message, array $context = []): void {}
    public function notice(string $message, array $context = []): void {}
    public function info(string $message, array $context = []): void {}
    public function debug(string $message, array $context = []): void {}
}