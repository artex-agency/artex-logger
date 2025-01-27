<?php declare(strict_types=1);
/**
 * Artex Logger
 * 
 * A high-performance, lightweight, and PSR-3-compliant logging 
 * interface for PHP applications. Designed with simplicity and 
 * efficiency in mind, the Artex Logger provides a robust foundation 
 * for managing application logs without sacrificing performance.
 * 
 * @package    Artex\Logger
 * @link       https://github.com/artex-agency/artex-logger
 * @link       https://artexsoftware.com
 * @license    Apache License 2.0
 * @copyright  2025 Artex Agency Inc.
 */
namespace Artex\Logger;

/**
 * LoggerInterface
 * 
 * Defines the contract for logging messages with various severity 
 * levels. Implementing classes are responsible for providing the logic 
 * to handle, format, and store logs appropriately.
 * 
 * This interface is fully PSR-3 compliant, ensuring compatibility with 
 * other libraries and tools adhering to the PHP-FIG Logger Interface 
 * standard.
 * 
 * @version  1.0.0
 * @author   James Gober <me@jamesgober.com>
 */
interface LoggerInterface
{
/**
 * Logs a message with the specified severity level and optional context data.
 * 
 * Implementing classes should handle the message formatting, storage, and any additional processing
 * necessary based on the provided log level and context.
 * 
 * ### Example Usage
 * ```php
 * $logger->log(200, 'User successfully logged in', ['user_id' => 123]);
 * ```
 * 
 * @param int    $level   The severity of the log (e.g., DEBUG, INFO, ERROR).
 * @param string $message The message to log. If an object is passed, it must implement __toString().
 * @param array  $context An optional array of key-value pairs providing additional information.
 *                        Example: ['user_id' => 123, 'action' => 'login'].
 * 
 * @return void
 */
public function log(int $level, string $message, array $context = []): void;

}