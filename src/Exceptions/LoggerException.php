<?php
declare(strict_types=1);
/**
 * LoggerException
 * 
 * A custom exception class for handling logger-related errors.
 *
 * @package    Artex\Logger\Exceptions
 * @link       https://github.com/artex-agency/artex-logger
 * @link       https://artexsoftware.com
 * @license    Apache License 2.0
 * @copyright  2025 Artex Agency Inc.
 */
namespace Artex\Logger\Exceptions;

use Exception;

/**
 * LoggerException class
 * Implements Exception.
 * 
 * @version  1.0.0
 * @author   James Gober <me@jamesgober.com>
 */
class LoggerException extends Exception
{
    /**
     * Constructs a new LoggerException.
     *
     * @param string $message The exception message.
     * @param int $code The exception code (optional).
     * @param Exception|null $previous A previous exception for chaining (optional).
     */
    public function __construct(string $message = "", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}