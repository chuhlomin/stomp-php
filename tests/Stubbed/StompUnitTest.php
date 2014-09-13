<?php

namespace FuseSource\Tests\Stubbed;

use FuseSource\Stomp\Stomp;
use PHPUnit_Framework_TestCase;

// Prepare mocking function calls
//require_once(__DIR__ . '/fusesource_stream_function_stubs.php');

class StompUnitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Stomp
     */
    private $sut;

    protected function setUp()
    {
        $this->sut = new Stomp('tcp://localhost:61613');
    }

    public function testReadFrameWithTrailingLineFeed()
    {
        $this->markTestSkipped('Needs client refactoring!');
        // Mock functions return values
        global $fusesourceStreamFunctionStubsBuffer;
        $fusesourceStreamFunctionStubsBuffer =array(
                "MESSAGE\n\nbody\x00\n",
                "MESSAGE\n\nbody\x00",
        );

        $this->sut->readFrame();
        $frame = $this->sut->readFrame();
        $this->assertSame(
            'MESSAGE',
            $frame->command
        );
    }

    public function testReadFrameWithLeadingLineFeed()
    {
        $this->markTestSkipped('Needs client refactoring!');
        $this->sut = new Stomp('tcp://localhost:61613');

        // Mock functions return values
        global $fusesourceStreamFunctionStubsBuffer;
        $fusesourceStreamFunctionStubsBuffer =array(
                "MESSAGE\n\nbody\x00",
                "\nMESSAGE\n\nbody\x00",
        );

        $this->sut->readFrame();
        $frame = $this->sut->readFrame();
        $this->assertSame(
            'MESSAGE',
            $frame->command
        );
    }
}