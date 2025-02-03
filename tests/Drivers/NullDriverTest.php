<?php

namespace Tests\Drivers;

use Artex\Logger\Drivers\NullDriver;
use PHPUnit\Framework\TestCase;

class NullDriverTest extends TestCase
{
    public function testDoesNotProduceOutput(): void
    {
        $driver = new NullDriver();

        ob_start();
        $driver->log(200, 'This should not appear', []);
        $output = ob_get_clean();

        $this->assertEmpty($output);
    }
}
