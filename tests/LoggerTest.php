<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Artex\Logger\Logger;

class LoggerTest extends TestCase
{
    private string $logFile;

    protected function setUp(): void
    {
        $this->logFile = sys_get_temp_dir() . '/test.log';
        @unlink($this->logFile); // Clear any existing logs before testing
    }

    protected function tearDown(): void
    {
        @unlink($this->logFile); // Clean up after tests
    }

    public function testLogsMessageAtAllowedLevel(): void
    {
        $logger = new Logger(200, $this->logFile);

        $logger->info("Test message", ["key" => "value"]);
        

        $this->assertFileExists($this->logFile);
        

        $logContent = file_get_contents($this->logFile);
        $this->assertStringContainsString('"level":"INFO"', $logContent);
        $this->assertStringContainsString('"message":"Test message"', $logContent);
        $this->assertStringContainsString('"context":{"key":"value"}', $logContent);
    }

    public function testDoesNotLogBelowThreshold(): void
    {
        $logger = new Logger(300, $this->logFile);

        $logger->info("Should not log");
        $this->assertFileDoesNotExist($this->logFile);
    }

    public function testLogRotation(): void
    {
        $tempDir = sys_get_temp_dir();
        $logFile = "{$tempDir}/test.log";
    
        // Cleanup: Remove all existing log files before the test
        array_map('unlink', glob($logFile . '*'));
    
        $logger = new Logger(threshold: 100, logFilePath: $logFile, maxFileSize: 50);
    
        // Write enough logs to trigger one rotation
        for ($i = 0; $i < 10; $i++) {
            $logger->debug("Log entry {$i}");
        }
    
        // Get all matching log files
        $files = glob($logFile . '*');
        echo "Files found after rotation: " . implode(', ', $files) . PHP_EOL; // Debugging output
    
        // Assert there are exactly 2 files (original + 1 rotated)
        $this->assertCount(2, $files, "Expected the original and one rotated log file.");
    }

    public function testAsynchronousLogging(): void
    {
        $logger = new Logger(200, $this->logFile, 1048576, true);

        $logger->info("Async log message");

        // Give the async process time to execute
        sleep(1);

        $this->assertFileExists($this->logFile);
        $logContent = file_get_contents($this->logFile);
        $this->assertStringContainsString("Async log message", $logContent);
    }

    public function testLogFormatting(): void
    {
        $tempDir = sys_get_temp_dir();
        $logFile = "{$tempDir}/test.log";
    
        if (file_exists($logFile)) {
            unlink($logFile); // Cleanup
        }
    
        $logger = new Logger(threshold: 100, logFilePath: $logFile);
        $logger->info('Formatted message', ['key' => 'value']);
    
        $logContents = file_get_contents($logFile);
        echo "Log Output:\n" . $logContents . PHP_EOL; // Debugging output
    
        $this->assertStringContainsString('"level":"INFO"', $logContents, "Log does not contain the level.");
        $this->assertStringContainsString('"message":"Formatted message"', $logContents, "Log does not contain the message.");
        $this->assertStringContainsString('"context":{"key":"value"}', $logContents, "Log does not contain the context.");
    }
    
}