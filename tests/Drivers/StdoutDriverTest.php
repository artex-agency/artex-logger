<?php
namespace Tests\Drivers;

use Artex\Logger\Drivers\StdoutDriver;
use PHPUnit\Framework\TestCase;

class StdoutDriverTest extends TestCase
{
    public function testLogsToStdout(): void
    {
        $driver = new StdoutDriver();

        ob_start();
        $driver->log(200, 'Test stdout log', ['key' => 'value']);
        $output = ob_get_clean();

        $this->assertStringContainsString('"level":"INFO"', $output);
        $this->assertStringContainsString('"message":"Test stdout log"', $output);
        $this->assertStringContainsString('"context":{"key":"value"}', $output);
    }
}
