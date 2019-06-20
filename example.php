<?php

require __DIR__ . '/vendor/autoload.php';

$context = new Viloveul\Mutator\Context();
$context->addHandler('test', function(Viloveul\Mutator\Contracts\Payload $payload) {
	$payload->foo = "baz";
	return $payload;
});

$payload = new Viloveul\Mutator\Payload([
	'foo' => 'bar'
]);
$result = $context->apply('test', $payload);
var_dump($result);