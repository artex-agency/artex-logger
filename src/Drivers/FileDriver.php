<?php declare(strict_types=1);
/**
 * FileDriver - A logger driver for writing logs to a file.
 *
 * @package    Artex\Logger\Drivers
 * @link       https://github.com/artex-agency/artex-logger
 * @link       https://artexsoftware.com
 * @license    Apache License 2.0
 * @copyright  2025 Artex Agency Inc.
 */
namespace Artex\Logger\Drivers;

use Artex\Logger\LoggerDriverInterface;
use Artex\Logger\Exceptions\LoggerException;

/**
 * FileDriver class
 * Implements LoggerInterface.
 * 
 * @version 1.0.0
 * @author  James Gober <me@jamesgober.com>
 */
class FileDriver implements LoggerInterface
{
    /** @var string $filePath File Path */
    protected string $filePath;
    protected bool $rotationEnabled;
    protected int $maxFileSize;

    /**
     * Constructs a new FileDriver instance.
     *
     * @param string $filePath The file path for the log file.
     * @param int|null $maxFileSize Optional max size for log rotation (default: null).
     */
    public function __construct(string $filePath, ?int $maxFileSize = null)
    {
        $this->filePath = $filePath;
        $this->maxFileSize = $maxFileSize ?? 0;
        $this->useRotation = $this->maxFileSize > 0;

        // Ensure the file is writable
        $this->validateFilePath();
    }

    /**
     * Logs a message to the file.
     *
     * @param string $formattedMessage The formatted log message.
     * 
     * @return void
     * 
     * @throws LoggerException If the file cannot be written to.
     */
    public function write(string $formattedMessage): void
    {
        try {
            // Rotate the file if needed
            if ($this->useRotation && file_exists($this->filePath)) {
                $this->rotateFileIfNeeded();
            }

            // Write the log message to the file
            file_put_contents($this->filePath, $formattedMessage . PHP_EOL, FILE_APPEND | LOCK_EX);
        } catch (\Throwable $e) {
            throw new LoggerException("Failed to write log to file: {$this->filePath}", 0, $e);
        }
    }

    /**
     * Validates the log file path.
     *
     * @return void
     * 
     * @throws LoggerException If the file path is not writable.
     */
    private function validateFilePath(): void
    {
        $directory = dirname($this->filePath);

        // Check if directory is writable
        if (!is_dir($directory) || !is_writable($directory)) {
            throw new LoggerException("Log directory is not writable: {$directory}");
        }

        // Check if file exists and is writable (or can be created)
        if (file_exists($this->filePath) && !is_writable($this->filePath)) {
            throw new LoggerException("Log file is not writable: {$this->filePath}");
        }
    }

    /**
     * Rotates the log file if it exceeds the max size.
     *
     * @return void
     */
    private function rotateFileIfNeeded(): void
    {
        if (filesize($this->filePath) >= $this->maxFileSize) {
            $timestamp = date('Ymd_His');
            $rotatedFile = "{$this->filePath}.{$timestamp}.log";

            // Rename the current log file
            rename($this->filePath, $rotatedFile);
        }
    }
}