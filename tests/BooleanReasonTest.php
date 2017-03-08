<?php

declare(strict_types=1);

namespace Anwinged\Reason;

use Anwinged\Reason\Status\BooleanStatus;
use PHPUnit\Framework\TestCase;

class BooleanReasonTest extends TestCase
{
    /**
     * @var Reason
     */
    private $trueReason;

    /**
     * @var Reason
     */
    private $falseReason;

    public function setUp()
    {
        $this->trueReason = new Reason(new BooleanStatus(true), ['yes', 'ok']);
        $this->falseReason = new Reason(new BooleanStatus(false), ['no', 'fail']);
    }

    public function testCanBeCloned()
    {
        $cloned = clone $this->trueReason;

        $this->assertNotSame($cloned, $this->trueReason);
    }

    public function testCanBeAppended()
    {
        $first = $this->trueReason->orX($this->falseReason);

        $this->assertTrue($first->getStatus()->isSuccess());
        $this->assertEquals(['yes', 'ok'], $first->getMessages());

        $second = $this->falseReason->orX($this->trueReason);

        $this->assertTrue($second->getStatus()->isSuccess());
        $this->assertEquals(['yes', 'ok'], $second->getMessages());
    }

    public function testCanBeJoined()
    {
        $first = $this->trueReason->andX($this->falseReason);

        $this->assertTrue($first->getStatus()->isFail());
        $this->assertEquals(['no', 'fail'], $first->getMessages());

        $second = $this->falseReason->andX($this->trueReason);

        $this->assertTrue($second->getStatus()->isFail());
        $this->assertEquals(['no', 'fail'], $second->getMessages());
    }

    public function testMessageMergedWhileReasonsAppended()
    {
        $first = new Reason(new BooleanStatus(true), ['yes', 'ok']);
        $second = new Reason(new BooleanStatus(true), ['good', 'success']);

        $appended = $first->orX($second);

        $this->assertTrue($appended->getStatus()->isSuccess());
        $this->assertEquals(['yes', 'ok', 'good', 'success'], $appended->getMessages());
    }

    public function testMessageMergedWhileReasonsJoined()
    {
        $first = new Reason(new BooleanStatus(true), ['yes', 'ok']);
        $second = new Reason(new BooleanStatus(true), ['good', 'success']);

        $joined = $first->andX($second);

        $this->assertTrue($joined->getStatus()->isSuccess());
        $this->assertEquals(['yes', 'ok', 'good', 'success'], $joined->getMessages());
    }
}
