<?php

class GeneralTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @return mixed
     */
    public function testMutable()
    {
        $payload = new Viloveul\Mutator\Payload(['foo' => 'bar']);
        $mutator = new Viloveul\Mutator\Manager();
        $mutator->addFilter('test', function (Viloveul\Mutator\Contracts\Context $ctx) {
            $ctx->foo = 'baz';
            return $ctx;
        });
        $result = $mutator->apply('test', $payload);
        $this->tester->assertEquals('baz', $result->foo);
    }
}
