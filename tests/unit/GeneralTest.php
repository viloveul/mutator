<?php

class GeneralTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected $ctx;

    public function _before()
    {
        $this->ctx = new Viloveul\Mutator\Context();
        $this->ctx->addHandler('test', function (Viloveul\Mutator\Contracts\Payload $payload) {
            $payload->foo = 'baz';
            return $payload;
        });
    }

    /**
     * @return mixed
     */
    public function testAddHandler()
    {
        $this->tester->assertTrue($this->ctx->hasHandler('test'));
    }

    /**
     * @return mixed
     */
    public function testMutation()
    {
        $payload = new Viloveul\Mutator\Payload(['foo' => 'bar']);
        $result = $this->ctx->apply('test', $payload);
        $this->tester->assertEquals('baz', $result->foo);
    }
}
