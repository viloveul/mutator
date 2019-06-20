<p align="center">
<a href="https://travis-ci.com/viloveul/mutator">
<img src="https://travis-ci.com/viloveul/mutator.svg" alt="Build Status">
</a>
<a href="https://packagist.org/packages/viloveul/mutator">
<img src="https://poser.pugx.org/viloveul/mutator/d/total.svg" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/viloveul/mutator">
<img src="https://poser.pugx.org/viloveul/mutator/v/stable.svg" alt="Latest Stable Version">
</a>
</p>

# Installation

make sure your php version > 7.0

```bash
composer require viloveul/mutator
```

## How

```php
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
```
