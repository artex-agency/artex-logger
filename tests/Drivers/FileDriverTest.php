<?php

namespace Tests\Drivers;

use Artex\Logger\Drivers\FileDriver;
use PHPUnit\Framework\TestCase;

class FileDriverTest extends TestCase
{
    private string $logFilePath = '/tmp/test-driver.log';

    protected function setUp(): void
    {
        @unlink($this->logFilePath); // Clean up before test
    }

    public function testWritesLogToFile(): void
    {
        $driver = new FileDriver($this->logFilePath, 1024);
        $driver->log(200, 'Test log message', ['key' => 'value']);

        $this->assertFileExists($this->logFilePath);
        $logContent = file_get_contents($this->logFilePath);
        $this->assertStringContainsString('Test log message', $logContent);
        $this->assertStringContainsString('"key":"value"', $logContent);
    }

    public function testLogRotation(): void
    {
        $driver = new FileDriver($this->logFilePath, 50); // Tiny size for rotation
        $driver->log(200, str_repeat('A', 100), []); // Write enough to trigger rotation

        $rotatedFiles = glob($this->logFilePath . '.*');
        $this->assertNotEmpty($rotatedFiles, 'Log file rotation did not occur');
        $this->assertFileExists($this->logFilePath, 'Main log file does not exist after rotation');
    }
}
